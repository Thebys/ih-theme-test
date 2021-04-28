<?php
/**
 * Template of the banner shortcode. Repurposed from featured banner.
 *
 *  This template is called from shortcodes/banner.php
 */

	/** @var $atts array Shortcode attributes */
	$img = $atts['background-image'];
    $mobileImage = $atts['background-image-mobile'];
	$overlay = $atts['overlay'];
	$overlayColor = $atts['overlay-color'];
	$overlayOpacity = $atts['overlay-opacity'];

	$title = $atts['title'];
	$text = $atts['text'];

	$primaryButtonText = $atts['primary-button-text'];
	$primaryButtonLink = $atts['primary-button-link'];

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
	<div class="bg bg-overlay"
	     style="<?= $overlayOpacity ? 'opacity: ' . $overlayOpacity : '' ?>; background-color: <?= $overlayColor ?>;"></div>
    <?php endif; ?>

	<h3 class="title"><?= $title ?></h3>

	<p><?= $text ?></p>

    <div class="buttons">
	<?php if($primaryButtonLink && $primaryButtonText): ?>
		<a href="<?= $primaryButtonLink ?>" anec="<?= $anec ?>" anea="<?= $anea ?>-primary-click" class="page-button-new"><?= $primaryButtonText ?></a>
	<?php endif; ?>
    </div>
</div>