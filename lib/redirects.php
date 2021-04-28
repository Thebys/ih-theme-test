<?php
/**
 * This file contains custom redirects to block users from accessing single pages of custom post types that don't have them.
 */

// don't allow access to the post types that don't have its own pages
// redirection separated into two cases:
// 1. post types that should be redirected to specific page (ie. team page)
// 2. post types that should be redirected to homepage
function custom_post_types_redirect()
{
	global $post;
	$reqURL = $_SERVER['REQUEST_URI'];
	// define post types to redirect to homepage
	$redirectToHome = ['author', 'organizer', 'poradatel', 'misto-konani', 'testimonial'];
	// define redirect rules to specific pages
	// the rules can include specific pages according to taxonomies
	// fragments can be also added to URL so window scrolls or modal opens
	$postTypeRedirects = [
		"coffee_break" => [
			"cs" => "/obcerstveni",
			"en" => "/catering",
			"prefix" => "modal-"
		],
		"space" => [
			"cs" => "/prostory",
			"en" => "/spaces",
			"prefix" => ""
		],
		"team" => [
			"cs" => "/tym",
			"en" => "/team",
			"prefix" => ""
		],
		"partner" => [
			"tax-redirects" => [
				"name" => "partner_categories",
				"values" => [
					"offices" => [
						"prefix" => "modal-",
						"result" => "/kancelar"
					],
					"offices-en" => [
						"prefix" => "modal-",
						"result" => "/office"
					],
					"coworking" => [
						"prefix" => "",
						"result" => "/benefity"
					],
					"coworking-en" => [
						"prefix" => "",
						"result" => "/benefits"
					]
				]
			]
		]
	];

	// all archives except posts page are redirected home
	if(is_archive() && !is_post_type_archive('post'))
		redirect_home();

	// custom post types redirect home
	foreach ($redirectToHome as $tag) {
		if(strpos($reqURL, '/'.$tag.'/') !== false) {
			redirect_home();
		}
	}

	// custom post types redirect to specific pages
	if(is_single()) {
		foreach ($postTypeRedirects as $postType => $rules) {
			if($postType == $post->post_type) {
				wp_redirect( home_url() . post_type_single_redirect($post, $rules), 301 );
				die();
			}
		}
	}
}
add_action( 'template_redirect', 'custom_post_types_redirect' );

function post_type_single_redirect(&$post, &$rules) {
	if(isset($rules["tax-redirects"]))
		return post_type_taxonomies_redirect($post, $rules["tax-redirects"]);

	if(ICL_LANGUAGE_CODE == 'cs')
		return $rules['cs'] . '#' . $rules["prefix"] . $post->post_name;
	else
		return $rules['en'] . '#' . $rules["prefix"] . $post->post_name;

}

function post_type_taxonomies_redirect(&$post, &$rules) {
	$terms = wp_get_post_terms($post->ID, $rules["name"]);
	$termSlugs = collect_terms_slugs_only($terms);
	foreach ($rules["values"] as $key => $termRules) {
		if(in_array($key, $termSlugs)) {
			return $termRules["result"] . '#' . $termRules["prefix"] . $post->post_name;
		}
	}
	return null;
}

function collect_terms_slugs_only(&$terms) {
	$slugs = [];
	foreach ($terms as $term) {
		$slugs[] = $term->slug;
	}
	return $slugs;
}

function redirect_home() {
	if(ICL_LANGUAGE_CODE == 'cs')
		wp_redirect(home_url());
	else
		wp_redirect(home_url().'/en/');
	die();
}