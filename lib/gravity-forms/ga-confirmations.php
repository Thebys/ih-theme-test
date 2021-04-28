<?php
/**
 * This file contains complete functionality of the modal window powered form confirmations together with Google Analytics tracking.
 */

// CUSTOM FORM SUBMIT CONFIRMATIONS
// Custom form confirmations redirect the user to the previously visited page (which is usually
// concrete service landing page). If the previously visited page is not part of our website
// the user is redirected to the URL specified in the administration of the website. This custom
// functionality is enabled on all forms that use redirect confirmation. This does not affect
// default text confirmations.
add_filter('gform_confirmation', 'gform_referrer_redirect', 11, 3);

// Functionality also appends a javascript code that will send a custom event to Google Analytics
// stating that a form was submitted. This is done firstly by storing the required data in cookies
// and then printing the script together with confirmation message in wp_footer hook. Based on the
// data in cookies a confirmation window will be displayed.
add_filter('gform_confirmation', 'gform_store_ga_data', 10, 3);
add_action( 'wp_footer', 'form_submit_confirmation');

function log_form_message($message) {
	file_put_contents(__DIR__ . '/../../log/forms.log', $message . PHP_EOL, FILE_APPEND);
}

function log_return_form_message($message, $toReturn) {
	log_form_message($message);
	return $toReturn;
}

// this function overwrites a redirect confirmation in case that the referrer (previous visited page) is part of our website
// if that is true, the user will be redirected to previously visited page while the query paramters (?form_submitted=...) are copied from
// the original redirect URL which will make the website display the right confirmation modal window
function gform_referrer_redirect($confirmation, $form, $entry) {

	// if confirmation type is not redirect (in that case confirmation would be an array) do nothing
	if(empty($confirmation['redirect']))
		return $confirmation;

	$referrerField = get_field_atts_by_label( $form, $entry, 'referrer' );

	// if the form does not have referrer field or it is empty do nothing
	if(!$referrerField || $referrerField['value'] == '')
		return log_return_form_message("Referrer empty. Redirect to " . $confirmation['redirect'], $confirmation);

	$referrerURL = parse_url($referrerField['value']);

	// if referrer URL is malformed do nothing
	if(!$referrerURL)
		return log_return_form_message("Referrer malformed. Redirect to " . $confirmation['redirect'], $confirmation);

	// if the referrer domain name is not same as the current domain do nothing
	if($_SERVER['HTTP_HOST'] !== $referrerURL['host'])
		return log_return_form_message("Referrer not part of our web. Redirect to ". $confirmation['redirect'], $confirmation);

	$referrerURL['query'] = parse_url($confirmation['redirect'])['query'];
	$referrerURL = http_build_url($referrerURL);

	log_form_message("Referrer part of our website. Redirect to: $referrerURL");

	// redirect to referrer with new query parameters
	return ['redirect' => $referrerURL];
}

// this function will store the data needed to register a form submit event to Google Analytics in cookies
// the data are stored in cookies so they are not as visible as if it would be GET parameters
// when HTTPS is not enabled the data can be easily read by third party (but the data would be easily read while the form is submitted anyway)
// the cookies are used so the data are accesible even after a redirect
function gform_store_ga_data($confirmation, $form, $entry) {
	$formID = $form['id'];

	// just for logging purposes
	$referrer = get_field_atts_by_label( $form, $entry, 'referrer' );
	if(!empty($referrer['value']))
		$referrer = $referrer['value'];
	log_form_message("////////////////////////////////////////////////////////////////");
	log_form_message("Form " . $form['title'] . " ($formID) sent. The referrer is: $referrer");
	log_form_message("User ID: " . $_COOKIE['_ga']);

	// in case the tracking script is part of classic confirmation
	// we do not do anything
	if(!is_array($confirmation))
		if(strstr($confirmation, 'form_submit_completed') !== false)
			return log_return_form_message("Basic confirmation that contains tracking code. Doing nothing.", $confirmation);

	// collect data needed for Google Analytics
	$anea = get_form_anea($form);
	$sender = get_form_sender($form, $entry);
	$location = get_form_response_location($form, $entry);

	// the form ga data are sent to client in case we redirect user
	// otherwise we store them in $_COOKIE just for this request and exit
	if(!empty($confirmation['redirect'])) {
		log_form_message("Original redirection is: " . $confirmation['redirect']);

		$anea = maybe_overwrite_form_anea($confirmation, $anea);

		setcookie('form_ga_anea', $anea, time() + 3600, '/');
		setcookie('form_ga_sender', $sender, time() + 3600, '/');
		setcookie('form_ga_location', $location, time() + 3600, '/');
		setcookie('form_ga_id', $formID, time() + 3600, '/');

		log_form_message("Setting cookies. form_ga_anea: $anea, form_ga_sender: $sender, form_ga_location: $location, form_id: $formID");

	} else {
		$_COOKIE['form_ga_anea'] = $anea;
		$_COOKIE['form_ga_sender'] = $sender;
		$_COOKIE['form_ga_location'] = $location;
		$_COOKIE['form_ga_id'] = $formID;

		log_form_message("Keeping data not in cookies. form_ga_anea: $anea, form_ga_sender: $sender, form_ga_location: $location, form_ga_id: $formID");

		return $confirmation;
	}

	// if the user ddi not send GA cookies, we log the event from the server
	// this should solve issue with adblock users and their missing subscriptions in GA
	if(empty($_COOKIE['_ga'])) {
		send_ga_data_server($anea, get_form_sender($form, $entry, true));
	}

	// add form parameter to the URL so cache is disabled
	$confirmationURL = parse_url($confirmation['redirect']);
	$confirmationURL['query'] = 'form=' . $anea;
	$confirmationURL = http_build_url($confirmationURL);

	log_form_message("Form parameter added, redirection: $confirmationURL");

	return ['redirect' => $confirmationURL];
}

// overwrite form slug (anea) in case it is specified in the redirect URL as a query parameter
// this is used for event form where we need two different GA events based on the space that is rented
function maybe_overwrite_form_anea(&$confirmation, $anea) {

	$redirectURL = parse_url($confirmation['redirect']);

	// if url does not have anea parameter, do nothing
	if(!$redirectURL || empty($redirectURL['query']))
		return $anea;

	$anea = str_replace('anea=', '', $redirectURL['query']);

	// add form parameter to the URL so cache is disabled
	$redirectURL['query'] = 'form='.$anea;
	// modify the confirmation
	$confirmation['redirect'] = http_build_url($redirectURL);

	log_form_message("Anea changes based on redirect parameter. anea: $anea, redirect: " . $confirmation['redirect']);

	// return new form anea
	return $anea;

}

// deregister form cookies every time they are present
// this cannot be done in footer hook because of 'headers already sent'
add_action( 'init', 'unset_form_cookies');
function unset_form_cookies() {
	if(!isset($_COOKIE['form_ga_anea']))
		return;

	log_form_message("Cleaning cookies on " . $_SERVER['REQUEST_URI'] . ". form_ga_anea: " . $_COOKIE['form_ga_anea'] .
	                 " , form_ga_sender: " . $_COOKIE['form_ga_sender'] . " , form_ga_location: " . $_COOKIE['form_ga_location'] .
	                 " , form_ga_id: " . $_COOKIE['form_ga_id']);

	setcookie('form_ga_anea', '', time() - 60, '/');
	setcookie('form_ga_sender', '', time() - 60, '/');
	setcookie('form_ga_location', '', time() - 60, '/');
	setcookie('form_ga_id', '', time() - 60, '/');
}

// function prints confirmation window together with Google Analytics code
function form_submit_confirmation() {
	if(empty($_COOKIE['form_ga_anea']))
		return;

	$anea = $_COOKIE['form_ga_anea'];
	$sender = !empty($_COOKIE['form_ga_sender']) ? $_COOKIE['form_ga_sender'] : "";
	$location = !empty($_COOKIE['form_ga_location']) ? $_COOKIE['form_ga_location'] : "";
	$formID = $_COOKIE['form_ga_id'];

	log_form_message("Printing confirmation. form_id: $formID, form_ga_anea: $anea, form_ga_sender: $sender, form_ga_location: $location");

	set_query_var( 'formAnea', $anea );
	set_query_var( 'formSender', $sender );
	set_query_var( 'formLocation', $location );
	set_query_var( 'formID', $formID );

	get_template_part( 'templates/form-tracking-snippet' );
	get_template_part( 'templates/form-confirmation' );
}

function send_ga_data_server($anea, $sender) {

	if( !($uaid = get_ga_id()) )
		return;

	$payload = [
		'v' => '1',
		't' => 'event',
		'tid' => $uaid,
		'cid' => intval($_SERVER['REQUEST_TIME_FLOAT']),
		'ec' => 'form_submit_completed',
		'ea' => $anea,
		'el' => $sender
	];

	$options = [
		"http" => [
			"header"  => "Content-type: application/x-www-form-urlencoded\r\n",
			"method" => "POST",
			"content" => http_build_query($payload)
		]
	];

	try {
		$context = stream_context_create($options);
		$result = file_get_contents('https://www.google-analytics.com/collect', false, $context);

		log_form_message('User does not have GA cookies. Sending event from the server with UA:' . $uaid);

		return false != $result;
	} catch (Exception $ex) {
		return false;
	}
}