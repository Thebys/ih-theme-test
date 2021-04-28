<?php
/**
 * Template of the blog page, in our terms the Stories page.
 */

/** @var $wpdb wpdb Wordpress Database object */
global $wpdb;
/** @var $wp_query WP_Query Current query object */
global $wp_query;

$blogPage = get_option('page_for_posts');

?>

<div class="stories-loop container">
    <div class="flex-boxes padding-top-30">

        <?php  do_action('before_loop'); ?>

        <?php

            $videoIndex = 0;
            if(!have_posts()) {
                _e( 'No posts found.', 'roots' );
            } else {
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'templates/content', 'summary' );
                }
            }
            do_action('after_loop');
        ?>
    </div>
</div>