<?php
/**
 * Template of the featured banner shortcode.
 *
 *  This template is called from shortcodes/banner.php
 */

	/** @var $atts array Shortcode attributes */
	$title = $atts['title'];
	$text = $atts['text'];
	$tags = explode(',', $atts['tags']);
	$primaryButtonText = $atts['primary-button-text'];
	$primaryButtonLink = $atts['primary-button-link'];
	$secondaryButtonText = $atts['secondary-button-text'];
	$secondaryButtonLink = $atts['secondary-button-link'];
	$img = $atts['background-image'];
    $mobileImage = $atts['background-image-mobile'];
	$highlightColor = $atts['highlight-color'];
	$overlay = $atts['overlay-color'];
	$overlay_opacity = $atts['overlay-opacity'];
	$anec = $atts['anec'];
	$anea = $atts['anea'];
?>

<div class="banner">
	<?php if($mobileImage): ?>
        <div class="bg bg-image mobile">
            <img class="image-fill-container" data-src="<?= $mobileImage ?>" alt="">
        </div>
	<?php endif; ?>
	<?php if($img): ?>
		<div class="bg bg-image">
			<img class="image-fill-container" data-src="<?= $img ?>" alt="">
		</div>
	<?php endif; ?>
    <?php if($overlay): ?>
	<div class="bg <?= 'bg-' . $overlay ?>"
	     style="<?= $overlay_opacity ? 'opacity: ' . $overlay_opacity : '' ?>"></div>
    <?php endif; ?>

	<h3 class="title">
		<?= $title ?>
	</h3>

    <div class="tags">
	<?php foreach($tags as  $tag): ?>
        <?php if($tag == '') continue; ?>
		<span class="tag c-<?= $highlightColor ?>"><?= $tag ?></span>
	<?php endforeach; ?>
    </div>

	<p>
		<?= $text ?>
	</p>

    <div class="buttons">
	<?php if($primaryButtonLink && $primaryButtonText): ?>
		<a href="<?= $primaryButtonLink ?>" anec="<?= $anec ?>" anea="<?= $anea ?>-primary-click" class="page-button-new bg-<?= $highlightColor ?>"><?= $primaryButtonText ?></a>
	<?php endif; ?>

	<?php if($secondaryButtonLink && $secondaryButtonText): ?>
		<a href="<?= $secondaryButtonLink ?>" anec="<?= $anec ?>" anea="<?= $anea ?>-secondary-click" class="page-button-new transparent"><?= $secondaryButtonText ?></a>
	<?php endif; ?>
    </div>
</div>