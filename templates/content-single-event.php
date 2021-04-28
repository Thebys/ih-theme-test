<?php
/**
 * DEPRECATED: Old layout for a single event page.
 *
 * This template is called from tribe-events/single-event.php
 *
 * TODO: Remove, old layout is not needed anymore.
 */

$venue = tribe_get_venue();
$location = null;
$color = null;
$location_link = tribe_get_venue_website_url();

if(tribe_get_venue() == 'Impact Hub Praha K10') {
	$location = 'k10';
	$color = 'yellow';
	$location_name = __('Impact Hub Prague K10', 'impact_hub_locations');
} elseif(tribe_get_venue() == 'Impact Hub Praha D10') {
	$location = 'd10';
	$color = 'mint';
	$location_name = __('Impact Hub Prague D10', 'impact_hub_locations');
}

$location_class = $location . ' ' . 'bg-' . $color;

?>
<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('container bg-white'); ?>>
        <header>
			<?php get_template_part('templates/content', 'feature-top'); ?>
            <a href="<?= $location_link ?>" target="_blank">
                <div class="location <?= $location_class ?>">
					<?= __('Takes place in', 'roots') . '&nbsp;' . $location_name ?>
                </div>
            </a>
        </header>

        <div class="event-content">
            <div class="entry-content">
				<?php the_content(); ?>

				<?php do_action('hub_after_event_the_content'); ?>

				<?php
				if(ICL_LANGUAGE_CODE == 'cs')
					$back_link = '/kalendar';
				else
					$back_link = '/en/calendar';
				?>
                <a href="<?= $back_link ?>" class="page-button-new margin-top-15"><?= __('Back to all Events', 'roots' ) ?></a>

            </div>

            <div class="event-sidebar">

				<?php
				$reg_action = get_field('registration_action');
				$reg_label = get_field('registration_label');

				if(is_user_logged_in() && $reg_action == 'eventbrite' && $reg_label && $eventbriteID = tribe_eb_get_id(get_the_ID()))
				{
					border_button_display( $reg_label, '#eventbrite-registration', 'dark', '');
				}

				if ( ( 'custom' == $reg_action )  ) {
					$reg_url = get_field('custom_registration_url');
				}

				// Fix for recurring events registration button
				if($post->post_parent != 0)
				{
					$reg_url = get_field('custom_registration_url', $post->post_parent);
					$reg_label = get_field('registration_label', $post->post_parent);
				}

				// Add subject line in case registration link is a mailto
				if(strpos($reg_url, 'mailto:') === 0) {
					// Use blog name if venue is not set, otherwise the name of venue is used
					$venue_title = tribe_get_venue();
					if($venue_title == '' || $venue_title == null)
						$venue_title = get_bloginfo( 'name' );

					// Prepare subject and add it to the registration link
					$subject = sprintf(__('Event registration for "%s" at %s', 'roots'), $post->post_title, $venue_title);
					$reg_url = $reg_url . "?subject=" . urlencode($subject);
				}
				?>

				<?php
				if ( $reg_label && $reg_url ): ?>
                    <div class="event-register">
						<?php border_button_display( $reg_label, $reg_url, 'dark', '_blank') ?>
                    </div>
				<?php endif; ?>

				<?php
				$organizer = tribe_has_organizer(get_the_ID());
				if ( $organizer  ) :
					?>
                    <div class="event-organizers">
                        <h2><?php _e('Event Organizers', 'roots'); ?></h2>
                        <p class="hep-organizer"><?php echo tribe_get_organizer( get_the_ID() ); ?></p>
						<?php echo get_the_post_thumbnail( tribe_get_organizer_id( get_the_ID(), 'full', array('class' => 'hep-orginizer-image') ) ); ?>
						<?php
						if(($website = tribe_get_organizer_website_url(get_the_ID())) != "")
						{
							?>
                            <div class="page-button"><a href="<?php echo $website; ?>" target="_blank"><?php _e('Website', 'roots') ?></a></div>
							<?php
						}

						if(($email = tribe_get_organizer_email(get_the_ID())) != "")
						{
							?>
                            <div class="page-button"><a href="mailto:<?php echo $email; ?>" target="_blank"><?php _e('Email', 'roots') ?></a></div>
							<?php
						}
						?>
                    </div>
				<?php endif; ?>

                <div class="event-datetime">
                    <h2><?php _e('Date & Time', 'roots'); ?></h2>

                    <p><?php get_template_part('templates/content', 'event-date') ?></p>
                </div>



				<?php
				$cost_for_members = get_field('cost_for_members');
				$cost_for_non_members = get_field('cost_for_non_members');

				if($post->post_parent != 0)
				{
					$cost_for_members = get_field('cost_for_members', $post->post_parent);
					$cost_for_non_members = get_field('cost_for_non_members', $post->post_parent);
				}
				?>
				<?php if ( $cost_for_members || $cost_for_non_members ): ?>
                    <div class="event-fee">
                        <h2><?php _e('Entry Fee', 'roots'); ?></h2>
						<?php if ( $cost_for_members ): ?>
                            <p><?php printf( '%s: %s', __('Cost for Members', 'roots'), $cost_for_members ); ?></p>
						<?php endif; ?>
						<?php if ( $cost_for_non_members ): ?>
                            <p><?php printf( '%s: %s', __('Cost for Non Members', 'roots'), $cost_for_non_members ); ?></p>
						<?php endif; ?>
                    </div>
				<?php endif; ?>

                <div class="event-location">
                    <h2><?= __('Event location', 'roots') ?></h2>
                    <address>
                        <strong class="<?= 'c-' . $color ?>"><?= tribe_get_venue(); ?></strong><br>
						<?= tribe_get_address(); ?><br>
						<?= tribe_get_city(); ?>
                    </address>
					<?php if($location_link != ""): ?>
                        <p><a href="<?= $location_link ?>" target="_blank"><?= __('More about the location', 'roots') ?> </a></p>
					<?php endif; ?>
                </div>

                <div class="event-cal-links">
					<?php echo red_link_display( __('Google Calendar', 'roots'), tribe_get_gcal_link() );?>
                    <div class="page-button"><a href="<?php echo get_permalink(); ?>?ical" target="_self"><?php _e('iCal Import', 'roots') ?></a></div>

                </div>

                <div class="event-updated">
                    <p><?php the_modified_date(' j. F Y', __('Updated on', 'roots') ) ?></p>
                </div>
            </div>
			<?php
			if($eventbriteID && is_user_logged_in())
			{
				?>
                <div id="eventbrite-registration">
                    <iframe width="100%" src="http://eventbrite.com/tickets-external?eid=<?php echo $eventbriteID; ?>"></iframe>
                </div>
				<?php
			}
			?>
        </div>
		<?php do_action('hub_after_event_content'); ?>
    </article>
<?php endwhile; ?>
