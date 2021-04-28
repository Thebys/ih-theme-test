<?php
/**
 * Calendar layout.
 *
 * This template is used by /page_calendar.php template.
 */

$events = ih_get_events(-1, false, null, 'hidden');
$monthly = ih_group_events_by_month($events);
$months_count = count($monthly);

$featured_events = get_featured_events();
if(get_field('primary_event') && !tribe_is_past_event(get_field('primary_event')))
	$featured_events['primary'] = get_field('primary_event');
if(get_field('secondary_event') && !tribe_is_past_event(get_field('secondary_event')))
	$featured_events['secondary'] = get_field('secondary_event');

$primaryOverride = get_field('primary_content_override');

$videoLink = get_field('video_link');

if(!get_field('video_slideslive')) {
	if(strstr($videoLink, 'facebook'))
		$videoLink .= '&autoplay=1&mute=0&height=300';
	else
		$videoLink .= '?autoplay=1';
}

$video = [
	'link' => $videoLink,
    'modal' => get_field('video_modal'),
	'label' => get_field('video_label'),
	'background' => get_field('video_background'),
	'slideslive' => get_field('video_slideslive'),
];

?>

<div class="calendar-content container padding-top-50">

	<div class="contained-row">
		
		<?php
		if (!$featured_events['primary'] and !$featured_events['secondary']) {
			set_query_var( 'primary', $featured_events['primary'] );
			set_query_var( 'secondary', $featured_events['secondary'] );
			set_query_var( 'video', $video );
			set_query_var( 'primaryOverride', $primaryOverride );
			get_template_part('templates/calendar-featured-events-no-events');
		}
		?>
		
		<?php if(count($events) < 1): ?>

			<div class="bg-light-grey events-list-month text-center no-events">
				<h2 class="c-grey fgt-bold new-headline padding-top-bottom-30 text-center"><?= __('Oh, that\'s unexpected!', 'roots') ?></h2>
				<p class="margin-top-bottom-0 padding-bottom-30 text-center"><?= __('No events are currently planned in the English calendar. How about checking the Czech version for more upcoming events?', 'roots') ?></p>
				<a href="<?= __('/kalendar/', 'roots') ?>" class="page-button-new"><?= __('Czech calendar', 'roots') ?></a>
			</div>

		<?php endif; ?>


		<?php
		if ($featured_events['primary'] and $featured_events['secondary']) {
			set_query_var( 'primary', $featured_events['primary'] );
			set_query_var( 'secondary', $featured_events['secondary'] );
			set_query_var( 'video', $video );
			set_query_var( 'primaryOverride', $primaryOverride );
			get_template_part('templates/calendar-featured-events');
		}
		?>
		
		<?php if($months_count > 0): ?>
			<?php ih_print_events_month( array_shift( $monthly ) ); ?>
		<?php endif; ?>

		<?php if(get_field('testimonials_slider_category')) : ?>
			<div class="padding-top-50">
				<?=
				testimonials_slider([
					'category' => get_field('testimonials_slider_category')->slug,
					'count' => get_field('testimonials_slider_count'),
					'anec' => 'calendar'
				]);
				?>
			</div>
		<?php endif; ?>

		<?php if(get_field('photos_slider')) : ?>
			<div class="padding-top-30">
				<?=
				photo_slider([
					'id' => get_field('photos_slider')->ID,
					'anec' => 'calendar'
				]);
				?>
			</div>
		<?php endif; ?>

		<?php if($months_count > 1): ?>

			<?php ih_print_events_month(array_shift($monthly), true); ?>

			<?php if(get_field('c2a_testimonial')) : ?>
				<div class="padding-top-50">
					<?=
					testimonial([
						'id' => get_field('c2a_testimonial')->ID,
						'photo' => get_field('c2a_testimonial_photo'),
						'anec' => 'calendar',
						'button_class' => 'light'
					]);
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if($months_count > 2): ?>
			<?php
			for($i = 2; $i < $months_count; $i++)
				ih_print_events_month(array_shift($monthly), true);
			?>
		<?php endif; ?>

	</div>

	<div class="padding-top-50">
		<?= do_shortcode("[service-tiles anec='calendar-page']"); ?>
	</div>

</div>