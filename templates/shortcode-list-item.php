<?php
/**
 * Template of the list of the List Item shortcode.
 *
 *  This template is called from shortcodes/list-item.php
 */

/** @var string[] $data List item data */
/** @var string $anec GA event category attribute for buttons (page specific) */

$color = $data['color'];
$brandColor = $data['brand_color'];
$name = $data['name'];
$description = $data['description'];
$tags = $data['tags'];
$url = $data['url'];
$circlePercentage = $data['progress'];
$disabled = $data['disabled'];
$border = $data['top_border'];
$button = $data['button_text'];

$anec = $data['anec'];
$anea = $data['anea'];

?>

<div class="list-item flex-boxes <?= $disabled ? 'disabled' : '' ?> <?= $border ? '' : 'no-border' ?>">
	<div class="col-xs-2 col-sm-2 col-md-1 valign-center">
		<div class="circle <?= $brandColor ? 'c-' . $brandColor : ''?>"
		     style="<?= $color ? 'color:' . $color : '' ?>">
			<svg viewBox="0 0 36 36" class="circular-chart">
				<path class="circle-bg"
				      d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
				/>
				<path class="circle"
				      stroke-dasharray="<?= $circlePercentage ?>, 100"
				      d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
				/>
			</svg>
		</div>
	</div>
	<div class="content col-xs-10 col-sm-7 col-md-9">
		<h3 class="c-grey new-headline fgt-bold title"><?= $name ?></h3>
		<?php foreach ($tags as $tag): ?>
            <?php if($tag == '') continue; ?>
			<span class="tag fgt-bold <?= $brandColor ? 'bg-' . $brandColor : '' ?>"
			      style="<?= $color ? 'background-color:' . $color : '' ?>">
				<?= $tag ?>
			</span>
		<?php endforeach; ?>
		<p><?= $description ?></p>
		<a
			href="<?= $url ?>"
			class="c2a-link visible-xs hidden-sm <?= $brandColor ? 'c-' . $brandColor : '' ?>"
			style="<?= $color ? 'color:' . $color : '' ?>"
			anec="<?= $anec ?>"
			anea="<?= $anea ?>">
			<?= $button ?><i class="fa fa-angle-right"></i>
		</a>
	</div>
	<div class="button valign-center col-xs-12 col-sm-3 col-md-2">
		<a
			href="<?= $url ?>"
			class="page-button-new transparent hidden-xs visible-sm visible-md visible-lg <?= $brandColor ? 'c-' . $brandColor : '' ?>"
			style="<?= $color ? 'color:' . $color . ';border-color:currentColor;' : '' ?>"
			anec="<?= $anec ?>"
			anea="<?= $anea ?>">
			<?= $button ?>
		</a>
	</div>
</div>