<?php
/**
 * Template for a single month view inside the calendar view.
 *
 * This template is used by ih_print_events_month() in lib/calendar.php. This function is then called from
 * templates/calendar.php for each month that has any events.
 */

/** @var bool $padding_top Whether the month should have top padding */
/** @var bool $padding_bottom Whether the month should have bottom padding */
/** @var array $monthly_events Array of events for this month */
?>

<div class="<?= $padding_top ? 'padding-top-50' : '' ?> <?= $padding_bottom ? 'padding-bottom-50' : '' ?>">
	<div class="bg-light-grey events-list-month">
		<h2 class="padding-top-bottom-30 text-center">
			<?php
			$m = get_month_name(intval(tribe_get_start_date($monthly_events[0]->ID, false, 'm')));
			$y = intval(tribe_get_start_date($monthly_events[0]->ID, false, 'Y'));
			if($y != intval((new DateTime())->format('Y')))
				echo $m . ' ' . $y;
			else
				echo $m;
			?>
		</h2>
		<?php
		foreach ($monthly_events as $event) {
			set_query_var( 'current_event', $event );
			get_template_part( 'templates/calendar-event' );
		}
		?>
	</div>
</div>
