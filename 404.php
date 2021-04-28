<?php
/**
 * Page not found template.
 *
 * This is wrapped by the base.php template.
 */
?>

<div class="contained-row padding-bottom-50">
	<div class="headline">
		<?php
			$reqURL = $_SERVER['REQUEST_URI'];
			if(strpos($reqURL,'/event/') !== FALSE) :
		?>
            <h1><?= __('Event Not Found', 'roots') ?></h1>
            <p><?= __('The event you are looking for has already taken its place.', 'roots') ?></p>
            <a href="<?= (ICL_LANGUAGE_CODE == 'cs') ? '/kalendar/' : '/en/calendar/' ?>" class="page-button-new margin-top-15">
                <?= __('Events calendar', 'roots') ?>
            </a>

        <?php else: ?>

            <h1><?= __('Not Found', 'roots') ?></h1>
            <p><?= __('Sorry, but the page you were trying to view does not exist.', 'roots') ?></p>

        <?php endif; ?>
	</div>
</div>