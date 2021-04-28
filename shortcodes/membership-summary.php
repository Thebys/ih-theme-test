<?php
/**
 * Shortcode that displays list of membership tarrifs together with a (possible) banner to highlight a service
 */

/**
 * The shortcode itself.
 *
 * Just parses the attributes and calls the template.
 */
function membership_summary($atts) {
	$atts = shortcode_atts(
		[
			'featured_show' => true,
			'featured_image' => '',
			'featured_overlay' => 'bg-greenhouse',
			'featured_title' => 'Hourly tariffs',
			'featured_tags' => 'best,nejbest',
			'featured_description' => 'Popisek, frajersky a mam ho jen na lokalu, tak ho nikdy nevidi. SKoda.',
			'featured_link_text' => 'Odkaz',
			'featured_link_url' => '/vedu-sem/',
			'disable' => '',
			'hide' => '',
			'anec' => ''
		],
		$atts,
		'membership-summary');

	ob_start();

	echo '<div class="gray-boxed membership-summary">';

	set_query_var( 'atts', $atts );
	set_query_var( 'anec', $atts['anec'] );

	if($atts['featured_show'])
		get_template_part('templates/shortcode-membership-summary-featured');

	membership_summary_tariffs($atts);

	echo '</div>';

	return ob_get_clean();
}
add_shortcode('membership-summary', 'membership_summary');

/**
 * Sets the inout data and loads the template of the tariffs listing
 */
function membership_summary_tariffs($atts) {
	$tariffs = membership_summary_get_tariffs($atts);

	$first = true;
	foreach ($tariffs as $key => $tariff) {
		if(strstr($atts['hide'], $key))
			continue;

		if($first)
			$tariff['top_border'] = false;
		if(strstr($atts['disable'], $key))
			$tariff['disabled'] = true;

		$tariff['anea'] = 'detail-' . $key;
		$tariff['anec'] = $atts['anec'];

		echo list_item_shortcode($tariff);

		$first = false;
	}
}

/**
 * Definition of the tariffs that are to be listed. Thanks to this we can modify the tariffs for all pages in a single place.
 */
function membership_summary_get_tariffs($atts) {
	$tariffs = [
		'connect' => [
			'name' => __('Virtual Membership', 'roots'),
			'description' => __('All the membership benefits from the comfort of your home.', 'roots'),
			'brand_color' => 'yellow',
			'tags' => [],
			'url' => __('/en/coworking/connect/', 'roots'),
			'progress' => 16
		],
		'day-pass' => [
			'name' => __('Day pass', 'roots'),
			'description' => __('You come and you work. With no commitment until the end of our business hours.', 'roots'),
			'brand_color' => 'pistachio',
			'tags' => [],
			'url' => __('/en/coworking/day-pass/', 'roots'),
			'progress' => 32
		],
		'hourly' => [
			'name' => __('Limited tariffs', 'roots'),
			'description' => __('10-100 hours per month. You choose how many hours you need.', 'roots'),
			'brand_color' => 'greenhouse',
			'tags' => [],
			'url' => __('/en/coworking/hourly/', 'roots'),
			'progress' => 48
		],
		'unlimited' => [
			'name' => __('Unlimited access', 'roots'),
			'description' => __('Day, night, weekends. Come whenever you want.', 'roots'),
			'brand_color' => 'hunter',
			'tags' => [],
			'url' => __('/en/coworking/unlimited/', 'roots'),
			'progress' => 64
		],
		'fix-desk' => [
			'name' => __('Fix desk', 'roots'),
			'description' => __('A desk and a chair reserved for you. With 24/7 access.', 'roots'),
			'brand_color' => 'ocean',
			'tags' => [],
			'url' => __('/en/coworking/fix-desk', 'roots'),
			'progress' => 80
		],
		'office' => [
			'name' => __('Office', 'roots'),
			'description' => __('Offices for small and large teams.', 'roots'),
			'brand_color' => 'midnight',
			'tags' => [],
			'url' => __('/en/office/', 'roots'),
			'progress' => 100
		],
	];


	foreach ($tariffs as $key => $tariff) {
		if(strstr($atts['disable'], $key))
			$tariffs[$key]['disabled'] = true;

		if(strstr($atts['hide'], $key))
			unset($tariffs[$key]);
	}

	return $tariffs;
}