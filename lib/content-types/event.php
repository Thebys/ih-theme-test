<?php
/*
 * Extending the Events post type which is defined by The Events Calendar plugin.
 *
 * Here we define additional fields via ACF and we also include additional code related to the Events functionality.
 */

// Override the published time display with the event date
// TODO: Not sure if this is really needed anymore.
add_filter( 'meta_time', 'event_meta_time' );
function event_meta_time($date) {
    if ( 'tribe_events' == get_post_type() ) {

        ob_start();
        get_template_part('templates/content', 'event-date');
        $date = ob_get_contents();
        ob_end_clean();
    }
    return $date;
}

// Disable the basic plugin stylesheet
// We don't need their frontend as we have defined ours
add_filter( 'tribe_events_stylesheet_url', '__return_false', 100 );

// http://wordpress.org/support/topic/plugin-the-events-calendar-tribe_is_upcoming-returns-true-but-shouldnt
function hub_tribe_is_upcoming() {
    return tribe_is_upcoming() && (get_post_type() == "" || get_post_type() == "tribe_events") && !is_404();
}

//TODO: Remove. This seems to not be used anywhere.
function is_tribe_list() {
    if ( hub_tribe_is_upcoming() || tribe_is_past() || tribe_is_day() || (is_single() && tribe_is_showing_all()) )
        return true;
    else return false;
}

// Disable some of the events widgets
add_action( 'widgets_init', 'disable_event_widgets', 101 );
function disable_event_widgets() {
    unregister_widget('TribeCountdownWidget');
    unregister_widget('TribeVenueWidget');
    unregister_widget('TribeEventsMiniCalendarWidget');
    unregister_widget('Tribe_Related_Posts_Widget');
}

add_action( 'after_setup_theme', 'disable_event_widget_actions', 100 );
function disable_event_widget_actions() {
    remove_action('widgets_init', 'tribe_countdown_register_widget');
    remove_action( 'widgets_init', 'tribe_venue_register_widget', 100 );
    remove_action( 'widgets_init', 'events_calendar_load_featured_widget',100);
}

/*  ==========================================================================
Exclude passed events from Yoast SEO XML Sitemap
========================================================================== */
add_filter( 'wpseo_sitemap_entry', 'exclude_passed_events', 1, 3 );
function exclude_passed_events($url, $type, $post) {
	if($post->post_type !== "tribe_events")
		return $url;
	$tribe = tribe_get_end_date($post->ID, true, DateTime::ATOM);
	$eventEnd = new DateTime($tribe, new DateTimeZone('Europe/Prague'));
	$current = new DateTime(null, new DateTimeZone('Europe/Prague'));
	if($eventEnd < $current)
		return false;
	return $url;
}

/*  ==========================================================================
Custom functionality that enables to create a link that will find upcoming event
from certain category. Function searches for parameter tag and then looks for next
upcoming event in that category. If the event is found, user is redirected to event detail.
========================================================================== */

// searches for tag parameter in the request - if found redirects to the detail
add_action('template_redirect', 'tag_scan');
function tag_scan()
{
	$event_category = get_query_var('tag');

	if ($event_category != '') {
		if (($event = get_upcomming($event_category)) != NULL) {

			$url = tribe_get_event_link($event);
			wp_redirect($url);
			die();
		}
	}
}

// registers 'tag' parameter so it gets propagated to the query
add_filter('query_vars', 'parameter_queryvars');
function parameter_queryvars($qvars)
{
	$qvars[] = 'tag';
	return $qvars;
}

// searches for upcoming event in the category
function get_upcomming($event_category)
{
	$event = tribe_get_events(
		array(
			'eventDisplay' => 'upcoming',
			'posts_per_page' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'tribe_events_cat',
					'field' => 'slug',
					'terms' => $event_category
				)
			)
		)
	);
	if (empty($event)) return NULL;
	else return $event[0];
}


/*  ==========================================================================
Init custom fields
========================================================================== */
add_action( 'after_setup_theme', 'event_custom_fields', 11) ;
/** Register custom fields for The Events Calendar events
 */
function event_custom_fields() {

	if(function_exists("register_field_group")) {
		register_field_group(array (
			'id' => 'acf_event-cost',
			'title' => 'Event Cost',
			'fields' => array (
				array (
					'key' => 'field_eventCostForAll',
					'label' => 'Cost for all',
					'name' => 'cost_for_all',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => 'Free',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5266e510469fd',
					'label' => 'Cost for Members',
					'name' => 'cost_for_members',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => 'Free',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5266e550469fe',
					'label' => 'Cost for Non Members',
					'name' => 'cost_for_non_members',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '$10',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_only_members',
					'label' => 'Only for members event',
					'name' => 'only_for_members',
					'type' => 'radio',
					'choices' => array (
						'non_members' => 'No',
						'only_members' => 'Yes',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => 'non_members',
					'layout' => 'vertical',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'tribe_events',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_event-registration',
			'title' => 'Event Registration',
			'fields' => array (
				array (
					'key' => 'field_526c215e95c00',
					'label' => 'Custom Registration URL',
					'name' => 'custom_registration_url',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_5266ed4c2538c',
					'label' => 'Registration Label',
					'name' => 'registration_label',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'tribe_events',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_event-organiser',
			'title' => 'Event Organiser',
			'fields' => array (
				array (
					'key' => 'field_526c16816fa40',
					'label' => 'Event Organisers',
					'name' => 'event_organisers',
					'type' => 'user',
					'instructions' => 'Control + click to select multple',
					'role' => array (
						0 => 'all',
					),
					'field_type' => 'multi_select',
					'allow_null' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'tribe_events',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'default',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));

		register_field_group(array (
			'id' => 'acf_event-photo-slider',
			'title' => 'Event Photos Slider',
			'fields' => array (
				array (
					'key' => 'field_eventPhotoSlider',
					'label' => 'Photos Slider',
					'name' => 'photo_slider',
					'type' => 'post_object',
					'post_type' => 'photo_slider',
					'allow_null' => true,
					'multiple' => false
				)
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'tribe_events',
					),
				),
			),
			'menu_order' => 2,
		));
	}
}
