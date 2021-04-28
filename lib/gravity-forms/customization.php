<?php
/**
 * This file contains many little customizations of Gravity Forms and also contains helper functions used in other customizations.
 */

//render form submit button with page-button-new CSS class
add_filter( 'gform_submit_button', 'customize_submit_button', 10, 2 );
function customize_submit_button($button,$form) {
	return str_replace('<input', '<input class="page-button-new bg-greenhouse"', $button);
}

// page will be scrolled to the form after submit
add_filter( 'gform_confirmation_anchor', '__return_true' );

//add option to exclude specific fields from {all_fields} table in e-mail notifications
add_filter( 'gform_merge_tag_filter', 'all_fields_extra_options', 11, 5 );
function all_fields_extra_options( $value, $merge_tag, $options, $field, $raw_value ) {
	if ( $merge_tag != 'all_fields' ) {
		return $value;
	}

	// usage: {all_fields:include[ID],exclude[ID,ID]}
	$include = preg_match( "/include\[(.*?)\]/", $options , $include_match );
	$include_array = explode( ',', rgar( $include_match, 1 ) );

	$exclude = preg_match( "/exclude\[(.*?)\]/", $options , $exclude_match );
	$exclude_array = explode( ',', rgar( $exclude_match, 1 ) );

	$log = "all_fields_extra_options(): {$field->label}({$field->id} - {$field->type}) - ";

	if ( $include && in_array( $field->id, $include_array ) ) {
		switch ( $field->type ) {
			case 'html' :
				$value = $field->content;
				break;
			case 'section' :
				$value .= sprintf( '<tr bgcolor="#FFFFFF">
                                                        <td width="20">&nbsp;</td>
                                                        <td>
                                                            <font style="font-family: sans-serif; font-size:12px;">%s</font>
                                                        </td>
                                                   </tr>
                                                   ', $field->description );
				break;
			case 'signature' :
				$url = GFSignature::get_signature_url( $raw_value );
				$value = "<img alt='signature' src='{$url}'/>";
				break;
		}
		GFCommon::log_debug( $log . 'included.' );
	}
	if ( $exclude && in_array( $field->id, $exclude_array ) ) {
		GFCommon::log_debug( $log . 'excluded.' );
		return false;
	}

	if(strstr(strtolower($field->label), 'newsletter'))
		return false;

	return $value;
}

add_filter( 'gform_replace_merge_tags', 'djb_gform_replace_merge_tags', 10, 7 );
/**
 * Replace custom merge tags.
 *
 * @link https://www.gravityhelp.com/documentation/article/gform_replace_merge_tags/
 *
 * @param string  $text Current text in which merge tags are being replaced.
 * @param object  $form Current Form object.
 * @param object  $entry Current Entry object.
 * @param boolean $url_encode Whether or not to encode any URLs found in the replaced value.
 * @param boolean $esc_html Whether or not to encode HTML found in the replaced value.
 * @param boolean $nl2br Whether or not to convert newlines to break tags.
 * @param string  $format Determines how the value should be formatted. Default is html.
 * @return string Modified data.
 */
function djb_gform_replace_merge_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
	if ( strpos( $text, '{current_hour}' ) !== false ) {
		$text = str_replace( '{current_hour}', current_time( 'G' ), $text );
	}
	if ( strpos( $text, '{current_minute}' ) !== false ) {
		$text = str_replace( '{current_minute}', current_time( 'i' ), $text );
	}
	if ( strpos( $text, '{current_am_pm}' ) !== false ) {
		$text = str_replace( '{current_am_pm}', current_time( 'A' ), $text );
	}
	return $text;
}

// HELPER FUNCTIONS

// finds the anea field and returns the anea value
// returns null if the field was not found
function get_form_anea($form) {
	foreach ($form['fields'] as $key => $field) {
		if(strstr($field->defaultValue, 'anea') !== false)
			return str_replace('anea=', '', $field->defaultValue);
	}

	return null;
}

// finds the email field and returns the value that user filled in
// returns empty string in case email field was not found
function get_form_sender($form, $entry, $serverSide = false) {
	$field_id = null;
	foreach ($form['fields'] as $key => $field) {
		if($field->type == 'email')
			$field_id = $field->id;
	}

	if($field_id == null)
		return "";

	$sender = $entry[$field_id] . ', ' . (new DateTime())->format('d-m-Y H:i:s');

	return $serverSide ? $sender . ', server-side' : $sender;
}

// finds field by label (used for hidden fields that do not have admin label)
function get_field_atts_by_label( $form, $entry, $label ) {
	foreach ( $form['fields'] as $field ) {
		$lead_key = $field->label;
		if ( strToLower( $lead_key ) == strToLower( $label ) ) {
			$field_atts = array(
				'value' => $entry[ $field->id ],
				'id'    => $field->id,
			);
			return $field_atts;
		}
	}
	return false;
}

// finds field by admin label
function get_field_atts_by_admin_label( $form, $entry, $adminLabel ) {
	foreach ( $form['fields'] as $field ) {
		$lead_key = $field->adminLabel;
		if ( strToLower( $lead_key ) == strToLower( $adminLabel ) ) {
			$field_atts = array(
				'value' => $entry[ $field->id ],
				'id'    => $field->id,
			);
			return $field_atts;
		}
	}
	return false;
}

// returns location (k10/d10) related to the form
// it can be defined either by the CSS class of the form or a select box used to pick a location
function get_form_response_location($form, $entry) {
	// get current location based on form class
	$location = '';
	if( strstr( $form['cssClass'], 'locationD10' ) !== false )
		$location = 'd10';
	if( strstr( $form['cssClass'], 'locationK10' ) !== false )
		$location = 'k10';

	// overwrite current location based on locationChoice select field
	if (get_field_atts_by_admin_label( $form, $entry, 'locationChoice' ) !== false) {
		$locationField = get_field_atts_by_admin_label( $form, $entry, 'locationChoice' );
		$choice = $locationField['id'];
		$location = rgar($entry, $choice);
	}

	return $location;
}