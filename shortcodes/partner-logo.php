<?php
/**
 * Shortcode that displays a clickable partner logo
 */

/**
 * The shortcode itself.
 *
 * Just parses the attributes and calls the template.
 */
function partner_logo($atts) {
	$atts = shortcode_atts(
		[
			'columns' => 4,
			'logo_title' => '',
			'logo_image' => '',
			'logo_link' => '',
			'logo_opacity' => 1,
			'grayscale' => true,
			'hover' => false,
			'new_tab' => true,
			'padding' => [],
			'anec' => '',
			'anea' => '',
		],
		$atts,
		'partner-logo');

	ob_start();

	if(!$atts['logo_image'])
		return '';

	set_query_var( 'logo', $atts );

	get_template_part('templates/shortcode-partner-logo');

	return ob_get_clean();
}
add_shortcode('partner-logo', 'partner_logo');