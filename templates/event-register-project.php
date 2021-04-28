<?php
/**
 * Template for a static call to project signup displayed on single event page.
 *
 * The call to action is displayed for Impact Hub events such as MashUp, Share, ... The event categories which
 * display the notice are defined in templates/event-single.php.
 *
 * This template is called from templates/event-single.php
 */
?>

<div class="bg-light-grey register-project upcoming-events-list">
	<h2><?= __('Ready to rock?', 'roots') ?></h2>

	<div class="event">
		<span class="title"><?= __('Do you run a project and want to show off? Do you have a tip for a project of a friend that fits? Let us know right now.', 'roots') ?></span>
		<a href="<?= __('/en/signup-project/', 'roots') ?>" class="page-button-new margin-top-15 small" anec="event-detail" anea="signup-project"><?= __('Submit a tip', 'roots') ?></a>
	</div>
</div>