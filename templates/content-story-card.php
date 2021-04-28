<?php
/**
 * Template used to display a Story from within the custom Elementor Loop element.
 *
 * This template is used on pages that display a few latest stories. This template is called from lib/elementor/IH_Widget_Loop.php
 */

global $post;
?>

<div <?php post_class('post-thumbnail col-xs-12 col-sm-6 col-md-4'); ?>>
    <div class="inner">
        <a href="<?= get_permalink(); ?>">
            <?php hub_post_thumbnail('banner-mobile'); ?>
            <h3><?php the_title(); ?></h3>
            <p><?php content_summary_excerpt(); ?></p>
        </a>
    </div>
</div>