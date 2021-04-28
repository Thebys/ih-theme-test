<?php

/** Shortcode that displays 4 service tiles used to present our services - usually on the bottom of a page.
 * The only supported attribute is 'anec' which is used for GA tracking of user click actions.
 * @param array $atts Array of user defined shortcode attributes
 *
 * @return string Returns HTMl code of the service tiles element
 */
function service_tiles($atts) {
	$atts = shortcode_atts(
		[ 'anec' => 'undefined' ],
		$atts,
		'service-tiles');

	ob_start();

	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-service-tiles');

	return ob_get_clean();
}
add_shortcode( 'service-tiles', 'service_tiles' );