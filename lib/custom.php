<?php
/**
 * This file contains many little customizations of the theme.
 */

/**
 * Enable theme features
 */
add_theme_support('post-thumbnails');
add_theme_support('root-relative-urls');    // Enable relative URLs
add_theme_support('rewrites');              // Enable URL rewrites
add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
add_theme_support('nice-search');           // Enable /?s= to /search/ redirect
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

/**
 * Impact Hub initial setup
 */
function roots_setup() {

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus(array(
		'primary_navigation' => __('Primary Navigation', 'roots'),
	));

}
add_action('after_setup_theme', 'roots_setup');


/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 940px is the default Bootstrap container width.
 */
if (!isset($content_width)) { $content_width = 940; }


/*  ==========================================================================
    Blog ID body class
    ========================================================================== */
add_filter('body_class', 'blog_id_body_class');
function blog_id_body_class($classes)
{
	global $blog_id;
	$classes[] = sprintf('blog-%s', $blog_id);

	return $classes;
}

/**
 * Add post/page slug as CSS class
 */
function roots_body_class($classes) {
	if (is_single() || is_page() && !is_front_page()) {
		$classes[] = basename(get_permalink());
	}

	return $classes;
}
add_filter('body_class', 'roots_body_class');

/*  ==========================================================================
    Custom Image sizes
    ========================================================================== */

add_action('init', 'hub_image_sizes');
function hub_image_sizes()
{
	// usually used in toggle-square elements
	add_image_size('mobile-square', 768, 768, true);
	// used in post-summary elements
	add_image_size('banner-mobile', 621, 407, true);
	// set banner images
	add_image_size( 'banner-new', 1170, 407, true );
	// post thumbnail on homepage
	add_image_size( 'homepage-news', 400, 400, true );
	// photo slider thumbnail
	add_image_size( 'slider-preview', 800, 533, false );
}


/*  ==========================================================================
    Enable Shortcodes in text widgets
    ========================================================================== */
add_filter('widget_text', 'do_shortcode');

/*  ==========================================================================
    Pagination after loop
    ========================================================================== */

add_action('after_loop', 'pagination_after_loop');
function pagination_after_loop()
{
	global $wp_query;
	if ($wp_query->max_num_pages > 1) {
		echo '<div class="pagination">';
		wp_pagenavi(array('options' => array(
			'first_text' => '<i class="fa fa-double-angle-left"></i>',
			'last_text' => '<i class="fa fa-double-angle-right"></i>',
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
		)));
		echo '</div>';
	}
}


/*  ==========================================================================
    Post classes
    ========================================================================== */
add_filter('post_class', 'media_post_class');
function media_post_class($classes)
{
	$classes[] = 'media';
	return $classes;
}

/*  ==========================================================================
    The excerpt for summary objects
    ========================================================================== */
add_action('hub_excerpt', 'content_summary_excerpt');
function content_summary_excerpt()
{
	global $post;

	if(!function_exists('the_advanced_excerpt')) {
		echo $post->post_excerpt;
		return;
	}

	$excerpt = $post->post_excerpt ? $post->post_excerpt : the_advanced_excerpt(array('allowed_tags' => array()), true);
	echo $excerpt;
}


/*  ==========================================================================
    Use the post thumbnail if we have one, otherwise show the default image
    ========================================================================== */
function hub_post_thumbnail($size = 'post-thumbnail')
{
	if (has_post_thumbnail()) {
		the_post_thumbnail($size);
	} else {
		$size = hub_get_image_size($size);
		printf('<img data-src="%s" alt="Impact Hub Default Banner" />',
			sprintf(get_template_directory_uri() . '/assets/img/banner/default-banner-%sx%s.jpg', $size['width'], $size['height'])
		);
	}
}

function hub_get_image_size($name)
{
	global $_wp_additional_image_sizes;

	if (isset($_wp_additional_image_sizes[$name]))
		return $_wp_additional_image_sizes[$name];

	return false;
}

/*  ==========================================================================
    Language selection
    ========================================================================== */
add_action('hub_language_select', 'hub_language_select_menu');
function hub_language_select_menu()
{
	if (function_exists('icl_get_languages')) {
		set_query_var('languages', icl_get_languages());
		get_template_part('templates/language-selector');
	}
}

/*  ==========================================================================
    Sanitize the meta output
    ========================================================================== */
add_filter('feature_meta', 'sanitize_feature_meta');
function sanitize_feature_meta($meta)
{
	global $post;

	ob_start();
	get_template_part('templates/entry', 'meta');
	$meta = ob_get_contents();
	ob_end_clean();

	return strip_tags($meta, '<time><span>');
}

add_filter('post_thumbnail_html', 'thumbnails_lazy_loading');
function thumbnails_lazy_loading($html) {
	return str_replace('src="', 'data-src="', $html);
}

function allow_svg_upload($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

// enable custom attributes for the HTML elements in
function change_mce_options( $init ) {
	//these are the default mce attributes for <a> tag
	$aNormal = 'accesskey|charset|class|coords|dir|ltr|rtl|href|hreflang|id|lang|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev|shape|style|tabindex|title|target|type';

	//add custom attributes
	$ext = "a[$aNormal|anec|anea]";

	//if extended_valid_elements already exists, add to it
	//otherwise, set the extended_valid_elements to $ext
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
		$init['extended_valid_elements'] = $ext;
	}

	//important: return $init!
	return $init;
}
add_filter('tiny_mce_before_init', 'change_mce_options');