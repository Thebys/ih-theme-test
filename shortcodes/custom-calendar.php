<?php
/**
 * Old calendar functionality.
 *
 * TODO: Can be removed. It is currently used only on the /alumni page.
 */

function custom_events_calendar($atts)
{
	if(!isset($atts['count']))
		$atts['count'] = -1;

	$args = array(
	'posts_per_page'        => $atts['count'],
	'ignore_sticky_posts'   => 1,
	'post_parent'           => NULL,
	'author'                => NULL,
	'offset'                => 0,
	'post_status'           => 'publish',
	'post_type'             => 'tribe_events',
	'meta_key'              => '_EventStartDate',
	'orderby'               => 'meta_value',
	'order'                 => 'ASC',
	'tax_query'             => array(),
	'suppress_filters'      => false
	);

	if(isset($atts['show-passed']))
	{
		add_action('pre_get_posts', 'show_passed_events', 51);
	}

	if(isset($atts['category']))
	{
		$categoryFilter = array (
			'taxonomy' => 'tribe_events_cat',
			'field'    => 'slug',
			'terms'    => explode(",",$atts['category']),
		);

		$args['tax_query'][0] = $categoryFilter;
	}

	if(isset($atts['exclude']))
	{
		$excludeFilter = array (
			'taxonomy' => 'tribe_events_cat',
			'field'    => 'slug',
			'terms'    => explode(",", $atts['exclude']),
			'operator' => 'NOT IN'
		);

		$args['tax_query'][1] = $excludeFilter;
	}

	$events = get_posts( $args );

	ob_start();

	global $post;

	$hideDesc = isset($atts['hide-description']);

	echo '<div class="clearfix events-calendar flex-boxes">';

	if(isset($atts['ws-call']))
		get_template_part('templates/content','calendar-ws-call');

	if(isset($atts['hide-location']))
		set_query_var( 'hide_location', true );

	foreach($events as $key => $post)
	{   
		setup_postdata($post);
		
		if($hideDesc)
			$post->post_content = NULL;

		get_template_part('templates/content', 'summary');
	}

	if(isset($atts['alumni-call']))
		get_template_part('templates/content','calendar-alumni-call');

	echo '</div>';

	$output = ob_get_clean();

	wp_reset_postdata();

	return $output;
}
add_shortcode('custom_calendar', 'custom_events_calendar');

function show_passed_events($query)
{
	$query->set('start_date', null);
}