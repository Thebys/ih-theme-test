<?php
/**
 * Template for the Pricing Table shortcode.
 *
 * This template is called from shortcodes/pricing-table.php
 */

/** @var string[] $atts Shortcode attributes */

$image        = $atts['head_image'];
$overlayClass = $atts['head_overlay'];
$title        = $atts['head_title'];
$topNote      = $atts['head_top_note'];
$bottomNote   = $atts['head_bottom_note'];
$hoverClass   = $atts['head_hover'] ? 'hover-effect' : '';
$shadow       = $atts['head_shadow'] ? 'shadow' : '';

$variants = $atts['variants'];
?>

<div class="pricing-table">
    <div class="inner">
        <div class="head flex-boxes <?= $hoverClass . ' ' . $shadow ?>" style="background-image: url('<?= $image ?>');">
            <div class="overlay <?= $overlayClass ?>"></div>
            <h2 class="name main-headline"><?= $title ?></h2>
            <?php if($topNote): ?><span class="top-note"><?= $topNote ?></span><?php endif; ?>
	        <?php if($bottomNote): ?><span class="bottom-note"><?= $bottomNote ?></span><?php endif; ?>
        </div>
        <?php foreach($variants as $var): ?>
            <div class="price">
                <span class="price-title"><?= $var['variant_title'] ?></span>
	            <?php if($var['variant_description']): ?>
                    <span class="price-subtitle"><?= $var['variant_description'] ?></span>
	            <?php endif; ?>
                <span class="no-vat"><span class="price-number"><?= $var['variant_price_novat'] ?></span></span>
	            <?php if($var['variant_price_vat']): ?>
                    <span class="vat hide"><span class="price-number"><?= $var['variant_price_vat'] ?></span></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>