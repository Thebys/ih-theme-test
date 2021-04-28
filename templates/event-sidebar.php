<?php
/**
 * Template used to display sidebar on the single event page with upcoming events.
 *
 * This template is called from templates/event-single.php
 */

$events_count = 8;
$events = ih_get_events($events_count + 1);
?>

<?php if(count($events) > 1): ?>
	<div class="bg-light-grey upcoming-events-list margin-bottom-15">
		<h2><?= __('Upcoming events', 'roots') ?></h2>

		<?php for($i = 0; $i < $events_count && $i < count($events); $i++): ?>
			<?php if($events[$i]->ID == $post->ID) continue; ?>
			<div class="event">
				<span class="date"><?= tribe_get_start_date($events[$i]->ID, false, 'j. n. Y') ?></span>
				<a href="<?= get_permalink($events[$i]) ?>"  anec="event-detail" anea="similar-event"><h3 class="title"><?= $events[$i]->post_title ?></h3></a>
			</div>
		<?php endfor; ?>

		<a href="https://www.google.com/calendar/render?cid=impacthub.cz_31tb5odgnv1gskp8viudcimafk@group.calendar.google.com" class="page-button-new margin-top-15 small" anec="event-detail" anea="entire-calendar"><?= __('Connect Calendar', 'roots') ?></a>			
	</div>
<?php endif; ?>