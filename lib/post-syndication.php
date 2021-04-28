<?php
/**
 * Custom post syndication using "Syndicate Out" plugin. This code is only required on the sender's side.
 *
 * Following functions alter behavior of the Syndicate Out plugin to enable post syndication between Czech Impact Hub
 * websites. The plugin uses WordPress built-in feature called XMLRPC.
 */

// Add custom post types we want to syndicate
add_filter('syndicate_out_post_types', 'syndicate_custom_post_type');
function syndicate_custom_post_type($cpts)
{
	$cpts[] = 'team';
	$cpts[] = 'partner';
	$cpts[] = 'tribe_events';
	return $cpts;
}

// Add WPML language code while syndicating the post
add_filter('syndicate_post_content', 'filter_post_content_for_cpt', 10, 2);
function filter_post_content_for_cpt($post, $postID)
{  
	$wpmlLangArray['key'] = '_wpml_language';
	$wpmlLangArray['value'] = wpml_get_language_information($postID)['language_code'];
	array_push($post['custom_fields'], $wpmlLangArray);

	if($post['post_type'] == 'post' || $post['post_type'] == 'page')
		return $post;

	$postTaxonomies = get_object_taxonomies(get_post($postID));
	$postTerms = array();
	foreach($postTaxonomies as $taxName)
	{
		$postTerms[$taxName] = wp_get_post_terms($postID, $taxName, array('fields' => 'names'));
	}
	
	$post['terms_names'] = $postTerms;

	foreach ($post['custom_fields'] as $key => $value) {
		if ( in_array( $value['key'], [ 'google-calendar-id', '_EventOrganizerID' ] ) ) {
			unset( $post['custom_fields'][ $key ] );
		}

		if ( $value['key'] == '_EventVenueID' ) {
			if ( $value['value'] == 31098 ) {
				$post['custom_fields'][$key]['value'] = 'online';
			} else {
				unset( $post['custom_fields'][ $key ] );
			}
		}
	}

	return $post;
}

// Disable duplication of Syndicate Out information when duplicating post to another language
add_filter( 'wpml_duplicate_custom_fields_exceptions', 'wpml_disable_syndicate_duplication' );
function wpml_disable_syndicate_duplication($exceptions)
{
	$exceptions[] = '_so_remote_posts';
	$exceptions[] = 'google-calendar-id';
	$exceptions[] = '_EventOrganizerID';
	return $exceptions;
}

//TODO: This function is used by the altered plugin which is not so cool - if theme is not present, plugin will brake
function thumbnail_synced($localID, $remoteID, $remoteServer)
{
	if(get_remote_synced_id($localID, $remoteServer) != false)
		return;
	$ar = json_decode(get_post_meta($localID, 'so_thumbnail_synced', true));
	$ar[] = array('server' => $remoteServer, 'id' => $remoteID);
	update_post_meta($localID,'so_thumbnail_synced',json_encode($ar));
}

function get_remote_synced_id($localID, $remoteServer)
{
	if(empty($remoteServer['server']))
		return false;

	$ar = json_decode(get_post_meta($localID, 'so_thumbnail_synced', true));

	if(empty($ar))
		return false;

	foreach ($ar as $record)
		if($record->server == $remoteServer['server'])
			return $record->id;

	return false;
}
