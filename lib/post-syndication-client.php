<?php
/**
 * Code used in relation to post syndication. This code is only required on the receiver's side.
 */

//HOTFIX for post syndication
//for some reason few of the meta fields of the Partner CPT were
//being rejected so the values were not propagated once syndicating
//using XML-RPC
//so this snippet adds capability to edit or add meta to any user
//that can edit the current post
add_filter( 'user_has_cap', 'allow_meta_options_to_be_added', 0, 3 );
function allow_meta_options_to_be_added($allcaps, $cap, $args) {
	if ( in_array( $args[0], array( 'edit_post_meta', 'add_post_meta' ), true ) ) {
		if ( current_user_can( 'edit_post', $args[2] ) ) {
			$allcaps[ $args[0] ] = true;
		}
	}
	return $allcaps;
}

/** Insert proper venue ID when syndicated post has an online venue
 * When XML-RPC request is in progress the function checks for _EventVenueID meta value. If that equals to 'online'
 * meta value is updated to the correct ID for this website. Function deregisters & registers save_post action to
 * prevent infinite looping.
 */
add_action( 'save_post', 'xmlrpc_localize_venueid' );
function xmlrpc_localize_venueid( $post_id ) {
	if(wp_is_post_revision($post_id) || wp_is_post_autosave($post_id))
		return;

	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		// Avoid infinite loops
		remove_action( 'save_post', 'xmlrpc_localize_venueid' );

		$venue = get_post_meta($post_id, '_EventVenueID', true);

		if($venue == 'online')
			update_post_meta($post_id, '_EventVenueID', 24289);

		add_action( 'save_post', 'xmlrpc_localize_venueid' );
	}
}