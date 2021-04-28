<?php
/**
 * Template of the partner logo shortcode
 *
 *  This template is called from shortcodes/partner-logo.php
 */

/** @var string[] $logo Logo data */

$bootstrapCol = 12 / intval($logo['columns']);
$title = $logo['logo_title'];
$imageUrl = $logo['logo_image'];
$link = $logo['logo_link'];
$opacity = $logo['logo_opacity'];
$hoverEffect = $logo['hover'];
$grayscaleFilter = $logo['grayscale'];
$newTab = $logo['new_tab'];
$anec = $logo['anec'];
$anea = $logo['anea'];

/** @var string[] $padding */
$padding = $logo['padding'];
$paddingString = '';

if(!empty($padding['top']))
	$paddingString .= 'padding-top: ' . $padding['top'] . $padding['unit'] . ';';
if(!empty($padding['right']))
	$paddingString .= 'padding-right: ' . $padding['right'] . $padding['unit'] . ';';
if(!empty($padding['bottom']))
	$paddingString .= 'padding-bottom: ' . $padding['bottom'] . $padding['unit'] . ';';
if(!empty($padding['left']))
	$paddingString .= 'padding-left: ' . $padding['left'] . $padding['unit'] . ';';

?>

<div class="partner-logo col-xs-6 col-md-<?= $bootstrapCol ?> <?= $hoverEffect ? 'hover' : '' ?> <?= $grayscaleFilter ? 'grayscale' : '' ?>"
     style="<?= $paddingString ?>opacity: <?= $opacity ?>;">
	<?php if($link) : ?>
	<a href="<?= $link ?>" target="<?= $newTab ? '_blank' : '' ?>" anec="<?= $anec ?>" anea="<?= $anea ?>">
	<?php endif; ?>
		<img data-src="<?= $imageUrl ?>" title="<?= $title ?>">
	<?php if($link) : ?>
	</a>
	<?php endif; ?>
</div>