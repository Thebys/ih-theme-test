<?php
/**
 * DEPRECATED: Template for the banner/carousel functionality used on the beginning of posts and pages.
 *
 * TODO: To be removed. But I believe it might still be used by the Single Story layout.
 */

global $wp_query;
?>

<?php do_action('before_feature'); ?>
<div <?php post_class('post-feature'); ?>>
	<?php get_template_part('templates/content', 'feature-top'); ?>
</div>
<?php do_action('after_feature'); ?>