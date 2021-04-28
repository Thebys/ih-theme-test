<?php
/**
 * Template for any other post type displayed in search results than the ones with custom template.
 *
 * This template is called from templates/search-result.php
 */
?>

<?php if($post->post_content) : ?>
<div class="post-excerpt">
	<?php 
	if(($seoDesc = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true)))
		echo $seoDesc;
	else
		do_action('hub_excerpt'); ?>
</div>
<?php endif; ?>