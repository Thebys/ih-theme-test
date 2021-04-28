<?php
/**
 * Template used for displaying a Slideslive video as toggle square element (with red overlay)
 *
 * This template is called by lib/slideslive.php
 */

$slide = $GLOBALS['current_slide'];
?>
<div class="toggle-square toggle-square-wrapper stories-square mashup-square">
	<div class="toggle-square-head">
		<img data-src="<?php echo $slide->thumbnail; ?>" class="attachment-mobile-square wp-post-image image-fill-container" alt="<?php echo $slide->name; ?>">
	</div>
	<div class="toggle-square-body">
		<div class="toggle-square-text">
			<h4 class="media-heading "> 
				<?php echo $slide->name; ?>
			</h4>
			<div class="page-button">
				<a href="<?php echo $slide->url; ?>" target="_blank" anec="slideslive-mashup-page" anea="button-click">
					<span class="action icon-arrow4-right"></span>
					<span><?php echo __('Go to video', 'roots'); ?></span> 
				</a>
			</div>
		</div>
	</div>
</div>