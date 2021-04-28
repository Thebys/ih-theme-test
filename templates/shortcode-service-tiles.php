<?php
/**
 * Template for the Service Tiles shortcode.
 *
 * This template is called from shortcodes/service-tiles.php
 */

/** @var array $atts Array of shortcode attributes specified by the user */
?>

<div class="service-tiles section-border-top text-center flex-boxes">
	<div class="bg-light-grey col-md-6 col-xs-12 valign-center">
		<div class="motto">
			<h2 class="c-hunter fgt-bold"><?= __('The space to make it happen', 'roots') ?></h2>
			<a class="light margin-top-15 page-button-new" href="<?= __('/en/about-us/', 'roots') ?>" anec="<?= $atts['anec'] ?>" anea="about-us"><?= __('What\'s Impact Hub?', 'roots') ?></a>
		</div>
	</div>
	<div class="bg-white col-md-6 col-xs-12 valign-center">
		<h2 class="c-grey new-headline"><?= __('Coworking membership', 'roots') ?></h2>
		<p class="padding-bottom-30"><?= __('Tariffs with just a few hours per month or unlimited access 24/7. Always with a package of benefits that make your work life easier.', 'roots') ?></p>
		<a class="page-button-new light" href="<?= __('/en/coworking/', 'roots') ?>" anec="<?= $atts['anec'] ?>" anea="coworking"><?= __('I\'ll give it a try', 'roots') ?></a>
	</div>
	<div class="bg-yellow col-md-6 col-xs-12 valign-center">
		<h2 class="c-grey new-headline padding-bottom-30"><?= __('Private office', 'roots') ?></h2>
		<div class="flex-boxes icons">
			<div class="col-xs-4">
				<img data-src="/wp-content/themes/impacthub/assets/img/icons/service-office-allinone.png" alt="Office All in One Icon">
				<p><?= __('All services under one roof', 'roots') ?></p>
			</div>
			<div class="col-xs-4">
				<img data-src="/wp-content/themes/impacthub/assets/img/icons/service-office-small-large.png" alt="Office All Sizes Icon">
				<p><?= __('For small start-ups and medium-sized companies', 'roots') ?></p>
			</div>
			<div class="col-xs-4">
				<img data-src="/wp-content/themes/impacthub/assets/img/icons/service-office-community.png" alt="Office Community Icon">
				<p><?= __('Be connected to a successful community', 'roots') ?></p>
			</div>
		</div>
		<a class="c2a-link" href="<?= __('/en/office/', 'roots') ?>" anec="<?= $atts['anec'] ?>" anea="office"><?= __('This sounds interesting', 'roots') ?><i class="fa fa-angle-right"></i></a>
	</div>
	<div class="bg-light-grey col-md-6 col-xs-12 valign-center">
		<h2 class="c-grey new-headline"><?= __('Project acceleration', 'roots') ?></h2>
		<p class="padding-bottom-30"><?= __('We will help you with the development of your commercial or social business regardless of your current stage.', 'roots') ?></p>
		<a class="c2a-link" href="<?= __('/en/acceleration/', 'roots') ?>" anec="<?= $atts['anec'] ?>" anea="acceleration"><?= __('Available programs', 'roots') ?><i class="fa fa-angle-right"></i></a>
	</div>
</div>