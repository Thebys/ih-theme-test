<?php
/**
 * DEPRECATED: Template that displays date of an event depending on whether the event spans through multiple days or not.
 *
 * TODO: To be removed. Not used by the new calendar layout.
 */
?>
<span class="hep-start-date" itemprop="startDate" content="<?php echo tribe_get_start_date(); ?>">
	<?php echo tribe_get_start_date(null, false, 'j. F Y'); ?>
</span>

<?php if ( tribe_event_is_multiday() ): ?>
    <span class="sep-multi">-</span>
    <span class="hep-end-date" itemprop="endDate" content="<?php echo tribe_get_end_date(); ?>">
        <?php echo tribe_get_end_date(null, false, 'j. F Y'); ?>
    </span>
<?php endif; ?>

<?php if ( !tribe_event_is_all_day() ): ?>
    <span class="hep-start-time"><?php echo tribe_get_start_date(null, false, 'H:i'); ?></span>
    <span class="sep">-</span>
    <span class="hep-end-time"><?php echo tribe_get_end_date(null, false, 'H:i'); ?></span>
<?php endif; ?>
