<?php
/**
 * Functionality that register new REST endpoint that enables automation of event creation through Google Forms.
 *
 * There are two Google Forms that are used by clients/employees to submit events to us. Those forms contain Google Apps Scripts
 * which take the submitted data and send it to our websites. The script basically creates an event concept which is then
 * manually checked and completed by a team member.
 *
 * Documentation of the GAS is available directly in the code of the scripts:
 * https://script.google.com/d/M95VO7Pnr_EO0SYGoZ6eaBpqnzb3yHH4d/edit?uiv=2&mid=ACjPJvE1jO6TX9aFRcW2rB1tRO5OreMPmNquPErFI2DPQ2rmFtCicX137pso1OcjGkxAU9mwWWQWWwZek2AXIwEfXC5CygJBktMHjNlS82irHrlx1JN3qlXFFH67LEK8VMzEd8Iz34r3
 * https://script.google.com/d/MGoRqKz9WMOfrtf9EkKC9Mpqnzb3yHH4d/edit?uiv=2&mid=ACjPJvFDI44rcQoFAkaATypXYxat8EVUQqJ-hMa87WQQK3trdPOIMIAb9ylbsOHnogcmN2EJXkmbPWH53EMdFyCD-4iE9Y7beOaGYttXv-lEbWBNfEkWglVje-2HkLt8SaQZEozEmkBwqw
 *
 * The two scripts are basically identical. They just serve different (public & internal) purposes.
 * TODO: The comments inside of the scripts are in Czech. Not nice.
 */

/*
 * Creates custom REST API endpoint that enables setting of post_meta
 */
add_action( 'rest_api_init', 'register_event_meta_endpoint');
function register_event_meta_endpoint() {
	register_rest_route(
		'tribe/events/v1',
		'/event-meta/(?P<id>\d+)',
		array(
			'methods' => 'POST',
			'callback' => 'rest_tribe_event_meta',
			'permission_callback' => 'rest_tribe_event_meta_auth'
		)
	);
}

/*
 * Allows only authenticated users.
 */
function rest_tribe_event_meta_auth() {
	return is_user_logged_in();
}

/*
 * Updates the meta data of the event.
 */
function rest_tribe_event_meta($data) {
	$event_id = $data['id'];
	$costValue = $data['cost_for_members'];
	$costNonValue = $data['cost_for_non_members'];
	$onlyMembersValue = $data['only_for_members'];
	$registrationUrlValue = $data['custom_registration_url'];
	$registrationLabelValue = $data['registration_label'];
	$costForAll = $data['cost_for_all'];

	$data = array_merge( $data,
		array(
			"custom_fields" => array(
				'cost_for_members'  => update_post_meta( $event_id, 'cost_for_members', $costValue ),
				'cost_for_non_members' => update_post_meta( $event_id, 'cost_for_non_members', $costNonValue),
				'only_for_members' => update_post_meta( $event_id, 'only_for_members', $onlyMembersValue),
				'custom_registration_url' => update_post_meta( $event_id, 'custom_registration_url', $registrationUrlValue),
				'registration_label' => update_post_meta( $event_id, 'registration_label', $registrationLabelValue),
				'cost_for_all' => update_post_meta( $event_id, 'cost_for_all', $costForAll )
			)
		)
	);
	return $data;
}