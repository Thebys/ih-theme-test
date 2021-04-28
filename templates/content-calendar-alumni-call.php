<?php
/**
 * Template of a static notice related to the Alumni Club.
 *
 * This template is added at the end of upcoming Alumni events on the /alumni page. Template is called from
 * shortcodes/custom-calendar.php
 */
?>

<div class="media col-xs-12 col-sm-6 col-md-4 col-lg-3 cat_alumni<?= (ICL_LANGUAGE_CODE != 'cs') ? '-en' : '' ?>  calendar-ws-call">
	<div class="media-object">
		<img data-src="/wp-content/themes/impacthub/assets/img/visit-hub.jpg" alt="Impact Hub">
	</div>
	<div class="media-body">
		<h4 class="media-heading c-grey"><?php _e("We are planning more Alumni Club events. Stay tuned.","roots"); ?></h4>
	</div>
</div>