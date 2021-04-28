<?php
/**
 * Utility functions.
 *
 * Functions that can be used throughout teh template and are not necessarily tied to a specific feature.
 */

function is_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}

//TODO: remove
function shorten_string($string, $length = 150) {
	if (strlen($string) >= $length) {
	    $string = substr($string, 0, $length). "&hellip;";
	}
	return $string;
}

//Add values for color picking in Custom Post Types - specifically, page.php and notification.php
function get_color_class_options() {
	return array(
		'bg-hunter' => 'Hunter green',
		'bg-fern' => 'Fern green',
		'bg-ruby' => 'Ruby red',
		'bg-black' => 'Black',
		'bg-grey' => 'Grey',
		'bg-white' => 'White',
		'bg-light-grey' => 'Light grey',
		'bg-light-red' => 'Light red',
		'bg-orange' => 'Orange',
		'bg-tan' => 'Tan orange',
		'bg-coral' => 'Coral red',
		'bg-midnight' => 'Midnight blue',
		'bg-blue' => 'Blue',
		'bg-mint' => 'Mint blue',
		'bg-ocean' => 'Ocean blue',
		'bg-greenhouse' => 'Greenhouse',
		'bg-pistachio' => 'Pistachio',
		'bg-yellow' => 'Yellow',
		'bg-impact-red' => 'Impact Red'
	);
}

// Generates description for a color selector.
function get_color_selector_description() {
	return '<p class="description">Pick one of the following colors: <code style="background-color: #075a61; color: #ffffff;">Hunter green</code> <code style="background-color: #3a9b89; color: #ffffff;">Fern green</code> <code style="background-color: #ca2c55; color: #ffffff;">Ruby red</code> <code style="background-color: #000; color: #fff;">Black</code> <code style="background-color: #404043; color: #ffffff;">Grey</code> <code style="background-color: #ffffff; color: #404043;">White</code> <code style="background-color: #f5f5f5; color: #404043;">Light grey</code> <code style="background-color: #ee4f3f; color: #ffffff;">Light red</code> <code style="background-color: #f78a3c; color: #ffffff;">Orange</code> <code style="background-color: #f6a974; color: #ffffff;">Tan orange</code> <code style="background-color: #ff5353; color: #ffffff;">Coral red</code> <code style="background-color: #0f3a5f; color: #ffffff;">Midnight blue</code> <code style="background-color: #3894c2; color: #ffffff;">Blue</code> <code style="background-color: #41bed0; color: #ffffff;">Mint blue</code> <code style="background-color: #266887; color: #ffffff;">Ocean blue</code> <code style="background-color: #7ebb55; color: #ffffff;">Greenhouse</code> <code style="background-color: #aacb70; color: #ffffff;">Pistachio</code> <code style="background-color: #ffd546; color: #ffffff;">Yellow</code>.</p>';
}