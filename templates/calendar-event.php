<?php
/**
 * Template for a single event displayed in the calendar view.
 *
 * This template is used by templates/calendar-month.php where it is included for each event in the month.
 */

/** @var WP_Post $current_event Event to be rendered */

$event = $current_event;
$eventID = $event->ID;
$startTime = tribe_get_start_time($eventID, 'H:i');
$endTime = tribe_get_end_time($eventID, 'H:i');
$multiday = tribe_event_is_multiday($eventID);
$startDate = tribe_get_start_date($eventID, false, 'j. n.');
$endDate = tribe_get_end_date($eventID, false, 'j. n.');
$classes = 'event flex-boxes ';
$classes = $multiday ? $classes . 'multiday' : $classes;

?>

<div <?php post_class($classes, $eventID) ?>>
    <span class="hidden-xs col-sm-2 date">
        <?= $multiday ? $startDate . '<br> - <br>' . $endDate : $startDate ?>
    </span>
	<!-- Don't forget to handle multiday events -->
	<div class="col-xs-12 col-sm-8 details">
        <span class="date-mobile hide">
            <?= $multiday ? tribe_get_start_date($eventID, false, 'j. n. Y') . '-' . tribe_get_end_date($eventID, false, 'j. n. Y')  : tribe_get_start_date($eventID, false, 'j. n. Y')  ?>
        </span>
		<span class="time">
            <?= $multiday ? __('Every day', 'roots') : '' ?>
            <?= $startTime . '-' . $endTime ?>
        </span>
		<a href="<?= get_permalink($current_event->ID) ?>"><h3 class="title"><?= $current_event->post_title; ?></h3></a>
		<div class="event-tags flex-boxes">
			<?= ih_get_venue_details($eventID, true, false, true) ?>
			<?php if(tribe_event_in_category('hub', $eventID) || tribe_event_in_category('hub-en', $eventID)): ?>
				<span class="bg-impact-red tag" data-tooltip="<?= __('Organized by Impact Hub', 'roots') ?>">Impact Hub</span>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-2 links text-center valign-center">
		<a href="<?= get_permalink($current_event->ID) ?>" class="c2a-link detail"><?= __('Detail', 'roots') ?><i class="fa fa-angle-right"></i></a>
	</div>
</div>