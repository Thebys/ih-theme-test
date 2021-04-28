<?php
/**
 *  Template for the single event page.
 *
 *  This template is called from tribe-events/single-event.php
 */

/** @var WP_Post $post Event to be displayed */

$startTime = tribe_get_start_time($post->ID, 'H:i');
$endTime = tribe_get_end_time($post->ID, 'H:i');
$multiday = tribe_event_is_multiday($post->ID);
$startDate = tribe_get_start_date($post->ID, false, 'j. n. Y');
$endDate = tribe_get_end_date($post->ID, false, 'j. n. Y');
$organizer = tribe_get_organizer($post->ID);
$organizerWeb = tribe_get_organizer_website_url($post->ID);

$reg_label = get_field('registration_label');
$reg_url = get_field('custom_registration_url');

// Add subject line in case registration link is a mailto
if(strpos($reg_url, 'mailto:') === 0) {
	// Use blog name if venue is not set, otherwise the name of venue is used
	$venue_title = tribe_get_venue();
	if ( $venue_title == '' || $venue_title == null ) {
		$venue_title = get_bloginfo( 'name' );
	}

	// Prepare subject and add it to the registration link
	$subject = sprintf( __( 'Event registration for "%s" at %s', 'roots' ), $post->post_title, $venue_title );
	$reg_url = $reg_url . "?subject=" . urlencode( $subject );
}

$costs = [
	'all' => get_field('cost_for_all'),
	'members' => get_field('cost_for_members'),
	'non_members' => get_field('cost_for_non_members')
];

// Fix for recurring events - use custom fields of the parent event
if($post->post_parent != 0) {
	$cost_for_members = get_field('cost_for_members', $post->post_parent);
	$cost_for_non_members = get_field('cost_for_non_members', $post->post_parent);
	$reg_url = get_field('custom_registration_url', $post->post_parent);
	$reg_label = get_field('registration_label', $post->post_parent);
}

if(ICL_LANGUAGE_CODE == 'cs')
	$back_link = '/kalendar';
else
	$back_link = '/en/calendar';
?>

<?php if(!get_field('new_page_intro')): ?>
    <?php get_template_part('templates/content', 'feature-top'); ?>
    <div class="page-intro">
        <div class="page-intro-bglayer bg-white"></div>
        <div class="contained-row page-headline">
            <h1><?= $post->post_title ?></h1>
            <?php if($reg_url && $reg_label) : ?>
                <a href="<?= $reg_url ?>" class="page-button-new light" target="_blank" anec="event-detail" anea="registration-top"><?= $reg_label ?></a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="contained-row">
    <div class="flex-boxes">
        <div class="col-xs-12 col-md-9 padding-bottom-30">
            <div class="event-details bg-light-grey">
                <h2><?= __('Event details', 'roots') ?></h2>
                <table class="margin-top-bottom-15">
                    <tbody><tr>
                        <th><?= __('Date', 'roots') ?></th>
                        <td>
                            <?= $multiday ? $startDate . '-' . $endDate : $startDate ?>
                            <a href="<?= tribe_get_single_ical_link() ?>" class="pull-right" anec="event-detail" anea="ical"><?= __('Add to iCal', 'roots') ?>&nbsp;<i class="fa fa-angle-right"></i></a>
                            <a href="<?= tribe_get_gcal_link() ?>" class="pull-right" anec="event-detail" anea="gcal"><?= __('Add to Google Calendar', 'roots') ?>&nbsp;<i class="fa fa-angle-right"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Time', 'roots') ?></th>
                        <td>
                            <?= $multiday ? __('Every day', 'roots') : '' ?>
                            <?= $startTime . '-' . $endTime ?>
                        </td>
                    </tr>
                    <?php if(get_field('only_for_members') == 'only_members'): ?>
                        <tr>
                            <th><?= __('Entry details', 'roots') ?></th>
                            <td><?= __('Members only', 'roots') ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( count(array_filter($costs, function ($el) { return $el !== null; })) > 0 ): ?>
                        <tr>
                            <th><?= __('Entry Fee', 'roots') ?></th>
                            <td>
                                <?php

                                if( !empty($costs['all']))
                                    echo $costs['all'];

                                if( !empty($costs['non_members']))
                                    echo $costs['non_members'] . ' ' . __('for public', 'roots') . '<br>';

                                if( !empty($costs['members']))
                                    echo $costs['members'] . ' ' .  __('for members', 'roots');

                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    global $sitepress;
                    $translations = $sitepress->get_element_translations($sitepress->get_element_trid($post->ID));
                    if(count($translations) > 1 && ICL_LANGUAGE_CODE == 'cs') : ?>
                        <tr>
                            <th><?= __('Language', 'roots') ?></th>
                            <td>
                                <?= __('English friendly', 'roots') ?>
                                <a href="<?= get_permalink($translations['en']->element_id) ?>" class="pull-right"><?= __('English description', 'roots') ?>&nbsp;<i class="fa fa-angle-right"></i></a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if($organizer): ?>
                        <tr>
                            <th><?= __('Organizer', 'roots') ?></th>
                            <td>
                                <?= $organizer ?>
                                <?php if($organizerWeb): ?>
                                    <a href="<?= $organizerWeb ?>" class="pull-right" anec="event-detail" anea="organizer"><?= __('Website', 'roots') ?>&nbsp;<i class="fa fa-angle-right"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th><?= __('Location', 'roots') ?></th>
                        <td><?= ih_get_venue_details($post->ID, false, true); ?></td>
                    </tr>
                    </tbody></table>
                <div class="description padding-top-bottom-30">
                    <?php the_content() ?>
                </div>
                <?php if($reg_url && $reg_label) : ?>
                    <a href="<?= $reg_url ?>" class="page-button-new light" target="_blank" anec="event-detail" anea="registration-bottom"><?= $reg_label ?></a>
                <?php endif; ?>
                <a class="c2a-link" href="<?= $back_link ?>" anec="event-detail" anea="all-events"><?= __('Back to all Events', 'roots' ) ?><i class="fa fa-angle-right"></i></a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3 padding-bottom-30">
            <?php
                get_template_part('templates/event-sidebar');

                get_template_part('templates/event-register-project');  
            ?>   
        </div>
    </div>
</div>

<?php if(get_field('photo_slider')): ?>
    <div class="contained-row">
        <?= do_shortcode('[photo-slider id="'. get_field('photo_slider')->ID .'" anec="event-detail"]') ?>
    </div>
<?php endif; ?>

<div class="padding-top-30">
    <?= do_shortcode('[service-tiles anec="event-detail"]') ?>
</div>