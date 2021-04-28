<?php
/**
 * Template of the "banner" feature of the Membership Summary shortcode.
 *
 *  This template is called from shortcodes/membership-summary.php
 */

/** @var string[] $atts Shortcode attributes */
/** @var string $anec GA event category attribute for buttons (page specific) */

$image = $atts['featured_image'];
$overlayClass = $atts['featured_overlay'];
$title = $atts['featured_title'];
$tags = $atts['featured_tags'] !== '' ? explode(',', $atts['featured_tags']) : [];
$description = $atts['featured_description'];
$link_url = $atts['featured_link_url'];
$link_text = $atts['featured_link_text'];
?>

<a href="<?= $link_url ?>" anec="<?= $anec; ?>" anea="featured" class="featured-tariff-wrapper">
    <div class="featured-tariff">
		<?php if(!empty($image)): ?>
            <div class="bg">
                <img class="image-fill-container" src="<?= $image ?>" alt="">
            </div>
		<?php endif; ?>
        <div class="bg <?= $overlayClass ?>"></div>
        <h3 class="c-white main-headline title"><?= $title ?></h3>
	    <?php foreach ($tags as $tag): ?>
            <span class="tag fgt-bold bg-white <?= str_replace('bg-', 'c-', $overlayClass) ?>">
                <?= $tag ?>
            </span>
        <?php endforeach;?>
        <p class="fgt-regular c-white"><?= $description ?></p>
        <button class="page-button-new transparent"><?= $link_text ?></button>
    </div>
</a>