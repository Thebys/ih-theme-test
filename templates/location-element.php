<?php
/**
 * Template for the Location Detail element.
 *
 * This template is called from shortcodes/location-detail.php
 */

/** @var $location ImpactHubLocation Instance of Impact Hub Location */
/** @var $actionText string Button text */
/** @var $actionLink string Button link */
?>

<div class="col-xs-12 col-md-10 col-lg-8 loc-wrap <?= $location->cssClass; ?>">
    <div class="flex-boxes loc-inner">
        <div class="col-sm-5 col-xs-12 loc-img text-center">
            <a href="<?= $actionLink; ?>">
                <img data-src="<?= $location->imageUrl; ?>" alt="Space <?= $location->name; ?>" class="image-fill-container">
            </a>
            <a href="<?= $actionLink; ?>" class="page-button-new white"><?= $actionText; ?></a>
        </div>
        <div class="loc-det col-xs-12 col-sm-7">
            <h2 class="hide"><?= $location->name; ?></h2>
            <a href="<?= $actionLink; ?>">
                <img data-src="<?= $location->iconUrl; ?>">
            </a>
            <p class="loc-addr"><?= $location->address; ?></p>
            <p class="loc-desc"><?= $location->description; ?></p>
            <div class="loc-specs clearfix">
                <div class="col-xs-4">
                    <a href="<?= $actionLink; ?>">
                        <i class="<?= $location->i1class; ?>"></i>
                        <p><?= $location->i1text; ?></p>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?= $actionLink; ?>">
                        <i class="<?= $location->i2class; ?>"></i>
                        <p><?= $location->i2text; ?></p>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?= $actionLink; ?>">
                        <i class="<?= $location->i3class; ?>"></i>
                        <p><?= $location->i3text; ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>