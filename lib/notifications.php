<?php
/**
 * Bottom left notifications functionality.
 *
 * Function to display the notifications is hooked to the wp_footer hook.
 */

//remove Yoast SEO metabox from notification custom post type
function remove_yoast_metabox_reservations(){
	remove_meta_box('wpseo_meta', 'hub_notification', 'normal');
}
add_action( 'add_meta_boxes', 'remove_yoast_metabox_reservations',11 );

//main function for displaying the notifications
function display_notification() {

	global $post;
	$post_id = $post->ID;
	// WP Query, in meta_query I check, if the notification should be displayed based on the field display_to
	$args = array(
		'post_type'             => array( 'hub_notification' ),
		'post_status'           => array( 'publish' ),
		'order'                 => 'DESC',
		'orderby'               => 'date',
		'meta_query'            => array(
			array(
				'key' => 'display_to',
				'value' => date('Y-m-d'),
				'compare' => '>=',
				'type' => 'DATE'
			)
		)
	);

	// The Query
	$notification_query = new WP_Query( $args );

	// The Loop
	if ( $notification_query->have_posts() ) {
		while ( $notification_query->have_posts() ) {
			$notification_query->the_post();
			// field_page_object holds ID of pages, where notifications should not be displayed, if this is the case, just continue to another iteration
			if (get_field('page_picker') == false) {
				$field_page_object = ['empty'];
			} else {
				$field_page_object = get_field('page_picker');
			}
			if(in_array($post_id, $field_page_object) === true) {
				continue;
			}
			get_template_part('templates/content', 'notification');
		}
	}

	// Restore original Post Data
	wp_reset_postdata();

}
add_action('wp_footer', 'display_notification', 10);

//validation for campaign field - no uppercase characters or spaces
function validate_campaign_notification_field( $valid, $value, $field, $input ){

	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}

	if (strpos($value, ' ') !== false)
	{
		$valid = "Name of the campaign should be a text without space.";
	}

	return $valid;
}
add_filter('acf/validate_value/name=campaign_id', 'validate_campaign_notification_field', 10, 4);