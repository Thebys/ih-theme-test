<?php
/**
 * This file contains functions that are used to built the Calendar layout. The page itself is defined in /templates/calendar.php
 */

/** Get events that fit the criteria. Events can be filtered based on their categories.
 * If $categories is supplied only events that are present in one of the categories will be returned.
 * If $excludeCategories is supplied only events that are not present in all categories will be returned.
 * @param int $count Number of events to return
 * @param bool $showPassed Show events that already passed
 * @param null $categories Categories to filter events by
 * @param null $excludeCategories Categories of events that shouldn't be returned
 *
 * @return array[WP_Post] Possibly empty array of event Post objects.
 */
function ih_get_events($count = -1, $showPassed = false, $categories = null, $excludeCategories = null) {

	$args = array(
		'posts_per_page'        => $count,
		'ignore_sticky_posts'   => 1,
		'post_status'           => 'publish',
		'meta_key'              => '_EventStartDate',
		'orderby'               => 'meta_value',
		'order'                 => 'ASC',
		'tax_query'             => array(),
		'suppress_filters'      => false,
	);

	// to show passed events we use start date of 2017, otherwise now is enough
	$args['start_date'] = $showPassed ? '2017-01-01' : 'now';

	if($categories)
	{
		$categoryFilter = array (
			'taxonomy' => 'tribe_events_cat',
			'field'    => 'slug',
			'terms'    => explode(",", $categories),
		);

		$args['tax_query'][0] = $categoryFilter;
	}

	if($excludeCategories)
	{
		$excludeFilter = array (
			'taxonomy' => 'tribe_events_cat',
			'field'    => 'slug',
			'terms'    => explode(",", $excludeCategories),
			'operator' => 'NOT IN'
		);

		$args['tax_query'][1] = $excludeFilter;
	}

	return tribe_get_events( $args );

}

/** Get supplied events grouped by month according to their start date.
 *
 * @param array[WP_Post] $events Events to be grouped.
 *
 * @return array[array[WP_Post]] Returns string indexed array where each element is array of events.
 * @throws Exception In case date parsing fails (shouldn't happen as it is not user input)
 */
function ih_group_events_by_month($events) {

	$grouped = [];

	foreach ($events as $event) {
		$eventStart = new DateTime( tribe_get_start_date( $event->ID, false, 'Y-m-d 00:00' ) );

		// if event started before current timestamp list it in the first month
		// because it is a recurring event which is still valid
		if($eventStart < new DateTime())
			$eventStart = new DateTime();

		$t = $eventStart->format('m/Y');

		if(!isset($grouped[$t]))
			$grouped[$t] = [$event];
		else
			$grouped[$t][] = $event;
	}

	return $grouped;
}

/** Directly output calendar month element.
 * Initiates template variables and loads the template. Note that the output goes directly to stdout in case it is not
 * handled by output buffer.
 * @param array[WP_Post] $events Events tha belong to the month
 * @param bool $paddingTop Add padding above the (grey) month box?
 * @param bool $paddingBottom Add padding below the (grey) month box?
 */
function ih_print_events_month($events, $paddingTop = false, $paddingBottom = false) {
	set_query_var( 'monthly_events', $events );
	set_query_var( 'padding_top', $paddingTop );
	set_query_var( 'padding_bottom', $paddingBottom );
	get_template_part( 'templates/calendar-month' );
}

/** Get a month name
 * Returns month name based on the number of the month. Index starts at 1 -> 1-12. Also enables translation.
 * @param $n Number of the month
 *
 * @return string Translated name of the month
 */
function get_month_name($n) {
	$months = [1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	return __($months[$n], 'roots-months');
}

/** Get featured events according to the current situation.
 * Featured events are collected according to the logic described directly in the code.
 * @return array[WP_Post] Array of events with keys 'primary' and 'secondary'
 */
function get_featured_events() {
	$result = ['primary' => null, 'secondary' => null];
	$mashup = ih_get_events(1, false, 'mashup', 'hidden');
	$featured = ih_get_events(2, false, 'featured', 'mashup,hidden');
	$upcoming = ih_get_events(2, false, null, 'featured,mashup,hidden');

	// if there is less than 2 events overall just return empty array
	if(count($mashup) + count($featured) + count($upcoming) < 2)
		return $result;

	if(count($mashup) > 0) {
		// if mashup is found use it as secondary and set primary to first featured or first upcoming
		$result['primary'] = count($featured) ? $featured[0] : $upcoming[0];
		$result['secondary'] = $mashup[0];
	} elseif (count($featured) == 2) {
		// if mashup is not found and there are 2 featured events, use them as primary and secondary
		$result['primary'] = $featured[0];
		$result['secondary'] = $featured[1];
	} elseif (count($featured) == 1) {
		// if mashup is not found and there is only 1 featured event, use featured as primary and upcoming as secondary
		$result['primary'] = $featured[0];
		$result['secondary'] = $upcoming[0];
	} else {
		// if mashup is not found and there are no featured events, use upcoming events as primary and secondary
		$result['primary'] = $upcoming[0];
		$result['secondary'] = $upcoming[1];
	}

	return $result;
}

/** Get venue badge and possibly the address
 * Function creates ImpactHubLocation object if the venue is one of the available locations. If not, address is just
 * a combination of venue name and address. There is also special case for online venue where we have a special badge.
 * Currently used in two scenarios:
 * 1. Calendar page - $badgeOnly with $tooltip
 * 2. Event detail - all details with $mapLink but without $tooltip
 * @param int $eventID ID of the event to return venue details for
 * @param bool $badgeOnly Whether to return only the badge
 * @param bool $mapLink Whether to return link to venue map
 * @param bool $tooltip Whether to show tooltip on badge hover
 *
 * @return string HTML code with the venue details
 */
function ih_get_venue_details($eventID, $badgeOnly = false, $mapLink = false, $tooltip = false) {
	switch (tribe_get_venue($eventID)) {
		case 'Impact Hub Praha K10':
			$location = ImpactHubLocation::getK10();
			break;
		case 'Impact Hub Praha D10':
			$location = ImpactHubLocation::getD10();
			break;
		case 'Impact Hub Brno':
			$location = ImpactHubLocation::getBrno();
			break;
		case 'Impact Hub Ostrava':
			$location = ImpactHubLocation::getOstrava();
			break;
		case 'Online':
			return ih_get_online_venue_details($badgeOnly);
			break;
		default:
			return $badgeOnly ? '' : tribe_get_venue($eventID) . ', ' . tribe_get_address($eventID). ', ' .tribe_get_city($eventID);
			break;
	}

	$output = $badgeOnly ? '' : $location->getAddressLine();
	$output .= $location->getBadge($tooltip);
	$output .= $mapLink ? sprintf('<a href="%s" class="pull-right">%s&nbsp;<i class="fa fa-angle-right"></i></a>', $location->googleMapsLink, __('Map', 'roots')) : '';
	return $output;
}

/** Get venue details for Online venue
 * Special case when the venue is Online - we have special badge for that and there is no address.
 * @param bool $badgeOnly Whether to return only the badge
 *
 * @return string HTML code with Online venue details
 */
function ih_get_online_venue_details($badgeOnly) {
	return sprintf(
		'%s <span class="location online" %s><img data-src="/wp-content/themes/impacthub/assets/img/online-badge.png" alt=""></span>',
		$badgeOnly ? '' : __('Event will take place online', 'roots'),
		$badgeOnly ? sprintf('data-tooltip="%s"', __('Event will take place online', 'roots')) : ''
	);
}

add_action( 'after_setup_theme', 'calendar_custom_fields' ) ;
/** Register custom fields for the calendar page.
 * Function registers custom fields that allow user to configure the looks and content of the calendar page.
 * Field group is displayed when a page has the page_calendar.php template.
 */
function calendar_custom_fields() {
	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;

	register_field_group(array (
		'id' => 'acf_calendar-details',
		'title' => 'Calendar content',
		'fields' => array (
			array(
				'key' => 'field_calendarPrimaryTab',
				'label' => 'Primary event',
				'name' => '',
				'instructions' => 'Select an event here to override default selection of the primary event.',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array (
				'key' => 'field_calendarPrimaryEvent',
				'label' => 'Primary event',
				'name' => 'primary_event',
				'type' => 'post_object',
				'instructions' => 'Select an event here to override which event will be displayed as the primary one.',
				'post_type' => 'tribe_events',
				'allow_null' => true,
				'multiple' => false,
				'wrapper' => array(
					'width' => '33'
				),
			),
			array (
				'key' => 'field_calendarPrimaryEventBackground',
				'label' => 'Background image',
				'name' => 'primary_event_background',
				'type' => 'image',
				'instructions' => 'Select an image that will be displayed below the overlay of the box. You can select no image to disable the background image.',
				'wrapper' => array(
					'width' => '33'
				),
			),
			array(
				'key' => 'field_calendarPrimaryEventOverlay',
				'label' => 'Background overlay',
				'name' => 'primary_event_overlay',
				'type' => 'select',
				'instructions' => get_color_selector_description(),
				'wrapper' => array(
					'width' => '33',
				),
				'choices' => get_color_class_options(),
				'default_value' => 'bg-midnight',
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value'
			),
			array (
				'key' => 'field_calendarPrimaryOverride',
				'label' => 'Primary event override',
				'name' => 'primary_content_override',
				'instructions' => 'This content will be displayed instead of the primary event box if not empty.',
				'type' => 'wysiwyg'
			),
			array(
				'key' => 'field_calendarSecondaryTab',
				'label' => 'Secondary event',
				'name' => '',
				'instructions' => 'Select an event here to override default selection of the secondary event.',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array (
				'key' => 'field_calendarSecondaryEvent',
				'label' => 'Secondary event',
				'name' => 'secondary_event',
				'instructions' => 'Select an event here to override which event will be displayed as the secondary one (aka instead of MashUp).',
				'type' => 'post_object',
				'post_type' => 'tribe_events',
				'allow_null' => true,
				'multiple' => false,
				'wrapper' => array(
					'width' => '33'
				),
			),
			array (
				'key' => 'field_calendarSecondaryEventBackground',
				'label' => 'Background image',
				'name' => 'secondary_event_background',
				'type' => 'image',
				'instructions' => 'Select an image that will be displayed below the overlay of the box. You can select no image to disable the background image.',
				'wrapper' => array(
					'width' => '33'
				),
			),
			array(
				'key' => 'field_calendarSecondaryEventOverlay',
				'label' => 'Background overlay',
				'name' => 'secondary_event_overlay',
				'type' => 'select',
				'instructions' => get_color_selector_description(),
				'wrapper' => array(
					'width' => '33',
				),
				'choices' => get_color_class_options(),
				'default_value' => array(
					0 => 'bg-hunter',
				),
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value'
			),
			array(
				'key' => 'field_calendarVideoTab',
				'label' => 'Video',
				'name' => '',
				'instructions' => 'Video that will be part of featured events widget. Video will be opened in modal window.',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array (
				'key' => 'field_calendarVideoLabel',
				'label' => 'Text',
				'name' => 'video_label',
				'type' => 'text',
				'wrapper' => array(
					'width' => '50'
				),
			),
			array (
				'key' => 'field_calendarVideoBackground',
				'label' => 'Background image',
				'name' => 'video_background',
				'type' => 'image',
				'instructions' => 'Select an image that will be displayed below the overlay of the box. You can select no image to disable the background image.',
				'wrapper' => array(
					'width' => '25'
				),
			),
			array(
				'key' => 'field_calendarVideoOverlay',
				'label' => 'Background overlay',
				'name' => 'video_overlay',
				'type' => 'select',
				'instructions' => get_color_selector_description(),
				'wrapper' => array(
					'width' => '25',
				),
				'choices' => get_color_class_options(),
				'default_value' => array(
					0 => 'bg-mint',
				),
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
			),
			array (
				'key' => 'field_calendarVideoLink',
				'label' => 'Video link',
				'name' => 'video_link',
				'instructions' => 'Enter an embed YouTube link (format: https://www.youtube.com/embed/IHOqHYEd5S8) or 
				Slideslive video ID (numeric part from Slideslive link: https://slideslive.com/38907518/aibrace). 
				If modal functionality is disabled, it can also be any other link and it will open in a new tab.',
				'type' => 'text',
				'wrapper' => array(
					'width' => '50'
				),
			),
			array (
				'key' => 'field_calendarVideoType',
				'label' => 'Video type',
				'name' => 'video_slideslive',
				'type' => 'true_false',
				'instructions' => 'Is it a YouTube, Facebook or Slideslive video?',
				'wrapper' => array(
					'width' => '25',
				),
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => 'Slideslive',
				'ui_off_text' => 'YouTube or Facebook',
			),
			array (
				'key' => 'field_calendarVideoModal',
				'label' => 'Video modal',
				'name' => 'video_modal',
				'type' => 'true_false',
				'instructions' => 'Do you want to open the link in modal window? If not, you can use any link and it 
				will open in a new tab.',
				'wrapper' => array(
					'width' => '25',
				),
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No',
			),
			array(
				'key' => 'field_calendarTestimonialsPhotosTab',
				'label' => 'Testimonials &amp; photos content',
				'name' => '',
				'instructions' => 'Configure testimonials and photos content.',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_calendarTestimonialsSliderCategory',
				'label' => 'Testimonials category',
				'name' => 'testimonials_slider_category',
				'type' => 'taxonomy',
				'taxonomy' => 'testimonial_categories',
				'field_type' => 'select',
				'allow_null' => 1,
				'return_format' => 'object',
				'multiple' => 0,
				'wrapper' => array(
					'width' => '50'
				),
			),
			array (
				'key' => 'field_calendarTestimonialsSliderCount',
				'label' => 'Count',
				'name' => 'testimonials_slider_count',
				'type' => 'number',
				'wrapper' => array(
					'width' => '50'
				),
			),
			array (
				'key' => 'field_calendarPhotosSlider',
				'label' => 'Photos slider',
				'name' => 'photos_slider',
				'type' => 'post_object',
				'post_type' => 'photo_slider',
				'allow_null' => true,
				'multiple' => false,
			),
			array (
				'key' => 'field_calendarC2A',
				'label' => 'Call to action testimonial',
				'name' => 'c2a_testimonial',
				'type' => 'post_object',
				'post_type' => 'testimonial',
				'allow_null' => true,
				'multiple' => false,
				'wrapper' => array(
					'width' => '60',
				),
			),
			array(
				'key' => 'field_calendarC2APhoto',
				'label' => 'Display photo?',
				'name' => 'c2a_testimonial_photo',
				'type' => 'true_false',
				'wrapper' => array(
					'width' => '40',
				),
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page_calendar.php'
				),
			),
		),
		'menu_order' => 0,
	));
}
