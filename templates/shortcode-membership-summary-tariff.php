<?php
/**
 * Template of the list of the Membership Tariffs displayed in the Membership Summary shortcode.
 *
 *  This template is called from shortcodes/membership-summary.php
 */

/** @var string[] $tariff Tariff data */
/** @var string $anec GA event category attribute for buttons (page specific) */

$color = $tariff['color'];
$name = $tariff['name'];
$description = $tariff['description'];
$tags = $tariff['tags'];
$url = $tariff['url'];
$circlePercentage = $tariff['progress'];
$key = $tariff['key'];
?>

<div class="tariff flex-boxes <?= empty($tariff['disabled']) ? '' : 'disabled' ?>">
    <div class="col-xs-2 col-sm-2 col-md-1 valign-center">
        <div class="circle c-<?= $tariff['color']; ?>">
            <svg viewBox="0 0 36 36" class="circular-chart">
                <path class="circle-bg"
                      d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <path class="circle stroke-<?= $color; ?>"
                      stroke-dasharray="<?= $circlePercentage ?>, 100"
                      d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"
                />
            </svg>
        </div>
    </div>
    <div class="content col-xs-10 col-sm-7 col-md-9">
        <h3 class="title"><?= $name ?></h3>
        <?php foreach ($tags as $tag): ?>
            <span class="tag fgt-bold bg-<?= $color ?>"><?= $tag ?></span>
        <?php endforeach; ?>
        <p><?= $description ?></p>
        <a
            href="<?= $url ?>"
            class="c2a-link c-<?= $color ?> visible-xs hidden-sm"
            anec="<?= $anec ?>"
            anea="detail-<?= $key ?>">
	            <?= __('Detail', 'roots') ?><i class="fa fa-angle-right"></i>
        </a>
    </div>
    <div class="button valign-center col-xs-12 col-sm-3 col-md-2">
        <a
            href="<?= $url ?>"
            class="page-button-new transparent c-<?= $color ?> hidden-xs visible-sm visible-md visible-lg"
            anec="<?= $anec ?>"
            anea="detail-<?= $key ?>">
                <?= __('Detail', 'roots') ?>
        </a>
    </div>
</div>