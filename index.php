<?php
/**
 * Default template of any archive page that should just list available posts.
 *
 * We don't really use this template anywhere. But it needs to be here cause it's required by Wordpress. Users
 * should not be able to visit any page with this template.
 */

$blogPageID = get_option('page_for_posts');

do_action('before_loop');

if (!have_posts()) : ?>
	<div class="alert">
		<?php if ( 'day' == get_query_var('eventDisplay') ): ?>
			<p><?php _e('Sorry, no events were found here.', 'roots'); ?></p>
			<p><?php echo red_link_shortcode(array('text' => __('Back to all Events', 'roots' ), 'href' => hep_events_page_url() ) ); ?></p>
		<?php else: ?>
			<?php _e('Sorry, no results were found.', 'roots'); ?>
		<?php endif; ?>
	</div>
	<?php //get_search_form(); ?>
<?php endif; ?>

	<div class="flex-boxes">
		<?php while ( have_posts()) : the_post(); ?>
			<?php do_action('loop_content'); ?>
		<?php endwhile; ?>
	</div>
<?php do_action('after_loop'); ?>