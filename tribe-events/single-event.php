<?php
/**
 * This file overrides the default The Events Calendar template for a single event view.
 *
 * The old_layout GET parameter can trigger displaying the event in pre-facelift layout.
 *
 * TODO: The old template can be removed now, it served just for development purposes.
 */

if(!isset($_GET['old_layout']))
	get_template_part('templates/event-single');
else
	get_template_part('templates/content', 'single-event');
