<?php
/**
 * Filter to send Gravity Forms e-mail confirmations in a fancy HTML template.
 *
 * This is applied to every form that has a CSS class of 'autoreply-template'.
 *
 * The content of the confirmation defined by the user in administration si basically just copied and inserted into an
 * HTML template. Template is located in /templates/email-auto-reply.php. The template receives e-mail content, subject
 * and location string that enables conditional logic based on location.
 */

add_filter( 'gform_pre_send_email', 'auto_reply_template', 10, 4 );
function auto_reply_template($email, $message_format, $notification, $entry) {
	$form = GFAPI::get_form($entry['form_id']);

	// check that the form has the class that activates this functionality
	if(strstr($form['cssClass'], 'autoreply-template') === false)
		return $email;

	// check that the notification is being sent to the autor of this entry
	// this disables wrapping of team notifications
	if($notification['toType'] !== 'field')
		return $email;


	// make the content available to the template
	set_query_var( 'notificationContent', $email['message'] );
	set_query_var( 'notificationSubject', $email['subject'] );
	set_query_var( 'notificationLocation',  get_form_response_location($form, $entry));

	// load the template and save its content to the $email array
	ob_start();
	get_template_part( 'templates/email', 'auto-reply' );
	$email['message'] = ob_get_clean();

	return $email;
}
