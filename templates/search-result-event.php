<?php
/**
 * Template for an Event displayed in search results.
 *
 * This template is called from templates/search-result.php
 */
?>

<h5 class="post-info">
	<?php get_template_part('templates/entry', 'meta'); ?>
</h5>
<?php if($post->post_content) : ?>
<div class="post-excerpt">
	<?php do_action('hub_excerpt'); ?>
</div>
<?php endif; ?>