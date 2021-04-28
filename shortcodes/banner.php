<?php
/** Shortcode to display a banner.
 * Returns HTML element containing a banner configured by elementor widget. 
 * Also supports
 * attributes 'photo' (if defined element will contain testimonial' photo), 'button_class' (custom CSS classes for C2A
 * button), 'wrapper_class' (custom CSS classes for wrapper, e.g. background color) and 'anec' (used for GA tracking).
 * @param array $atts Shortcode attributes defined by the user
 *
 * @return string HTML code of the banner element or empty string if no banners were found
 */
function banner($atts) {
	$atts = shortcode_atts(
		[
			'title' => '',
			'text' => '',
			'background-image' => '',
			'background-image-mobile' => '',
			'overlay' => false,
			'overlay-color' => '',
			'overlay-opacity' => 0,			
			'primary-button-text' => '',
			'primary-button-link' => '',
			'anec' => '',
			'anea' => '',
		],
		$atts,
		'banner');

	ob_start();

	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-banner');

	return ob_get_clean();
}
add_shortcode( 'banner', 'banner' );