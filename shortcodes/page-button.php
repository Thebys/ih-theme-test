<?php

/** Shortcode for Impact Hub styled button
 *
 * @return string Returns HTML code of the headline.
 */
function shortcode_page_button($atts) {
	$atts = shortcode_atts(
		[
			'text' => 'Button text',
			'link' => [
				'url' => '#',
				'is_external' => false,
				'nofollow' => false
			],
			'modal' => false,
			'anec' => null,
			'anea' => null,
			'style' => [],
			'size' => null,
			'text_color' => null,
			'elementor_widget' => null
		],
		$atts,
		'page-button');


	ob_start();

	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-page-button');

	return ob_get_clean();
}
add_shortcode( 'page-button', 'shortcode_page_button' );
