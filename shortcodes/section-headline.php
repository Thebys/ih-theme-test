<?php

/** Shortcode for a section headline
 * Shortcode renders a headline together with an introduction paragraph.
 * Both headline and introduction text support HTML.
 *
 * @return string Returns HTML code of the headline.
 */
function shortcode_section_headline($atts) {
	$atts = shortcode_atts(
		[
			'headline_text' => null,
			'headline_level' => 'h2',
			'headline_size' => 'default',
			'intro_text' => null,
			'fullwidth' => false,
			'padding' => true,
			'elementor_widget' => null
		],
		$atts,
		'section-headline');

	if($atts['headline_text'] == null && $atts['intro_text'] == null)
		return 'Both headline text and intro text are empty.';

	ob_start();

	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-section-headline');

	return ob_get_clean();
}
add_shortcode( 'section-headline', 'shortcode_section_headline' );
