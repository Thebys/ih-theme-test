<?php
/**
 * Template used for displaying a Slideslive video the same way as a Story.
 *
 * This template is called by lib/slideslive.php and this functionality is mainly used in home.php.
 */

$slide = $GLOBALS['current_slide'];

$description = $slide->description;
$maxLength = 180;
$descLength = strlen($description);

if($maxLength < $descLength)
	$description = substr($description, 0, strpos(wordwrap($description, $maxLength), "\n")) . " ...";

if($descLength < 10)
	$description = "";

if(ICL_LANGUAGE_CODE != 'cs')
	$description = "";

?>
<div class="media col-xs-12 col-sm-6 col-md-4 col-lg-3 slides-live-story" >
	<div class="media-object">
		<a href="<?php echo $slide->url ?>" target="_blank" anec="slideslive-in-stories" anea="thumbnail-click">
			<img data-src="<?php echo $slide->thumbnail; ?>" class="attachment-mobile-square wp-post-image image-fill-container" alt="<?php echo $slide->name; ?>">
			<div class="play-button">
				<i class="icon-circled-play"></i>
			</div>
		</a>
	</div>
	<div class="media-body">
		<h4 class="media-heading ">
			<a href="<?php echo $slide->url ?>" target="_blank" anec="slideslive-in-stories" anea="name-click">
				<?php echo $slide->name; ?>
				<i class="fa fa-external-link"></i>
			</a>
		</h4>
	</div>
	<div class="post-excerpt">
		<?php echo $description; ?>
	</div>
</div>