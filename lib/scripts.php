<?php
/**
 * This file contains definitions and registrations of CSS, JS and fonts. Also registers customizer fields for GA, GTM and Google Maps.
 */

// Disable WPML frontend styles
define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);

/**
 * Enqueue scripts and stylesheets
 */
function roots_scripts() {
    $theme_version = wp_get_theme()->get('Version');

	wp_enqueue_style('roots_fontawesome', get_template_directory_uri() . '/assets/dist/fontawesome.css', false, $theme_version);

    if ( !is_admin() ) {
	    // load custom Open Sans font instead of the default one
	    wp_deregister_style( 'open-sans' );
	    wp_enqueue_style('open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,800&subset=latin,latin-ext&display=swap', false, null);
	    wp_enqueue_style('arima-madurai', 'https://fonts.googleapis.com/css2?family=Arima+Madurai:wght@900&display=swap', false, null);

	    wp_enqueue_style('roots_bootstrap', get_template_directory_uri() . '/assets/dist/bootstrap.css', null, $theme_version);
	    wp_enqueue_style('roots_style', get_template_directory_uri() . '/assets/dist/styles.css', ['roots_bootstrap'], $theme_version);

        wp_enqueue_script('roots_main', get_template_directory_uri() . '/assets/dist/main.js', ['jquery'], $theme_version );
	    wp_enqueue_script('roots_maps', get_template_directory_uri() . '/assets/dist/maps.js', ['roots_main'], $theme_version, false);
	    wp_enqueue_script('roots_sliders', get_template_directory_uri() . '/assets/dist/sliders.js', ['roots_main'], $theme_version, false);

	    if(get_google_maps_api_key())
	        wp_enqueue_script('gmaps-js', 'https://maps.googleapis.com/maps/api/js?key='. get_google_maps_api_key() .'&amp;callback=initMaps',null, null, true);

	    // Deregister plugin styles
	    wp_dequeue_style('wp-pagenavi');
	    wp_dequeue_script('tribe-gmaps');
	    wp_dequeue_script('tribe-events-pro-geoloc');
	    wp_dequeue_style('tribe-common-skeleton-style');
	    wp_dequeue_style('wp-block-library');
	    wp_dequeue_style('tribe-tooltip');
    }
}
add_action('wp_enqueue_scripts', 'roots_scripts', 100);

/*******************************************************************
 * GOOGLE TAG MANAGER
 */

// Return Google Tag Manager retrieved from Theme Mods
// Return null when user is logged in so admins are not included in analytics data
function get_tag_manager_id() {
	if(is_user_logged_in())
		return null;

	return get_theme_option_ifset('google_tag_manager_id');
}

// Return Google Analytics Tracking ID
function get_ga_id() {
	return get_theme_option_ifset('google_analytics_id');
}

// Return Google Maps API key
function get_google_maps_api_key() {
    return get_theme_option_ifset('google_maps_api_key');
}

// Helper to simplify the above functions.
function get_theme_option_ifset($key) {
	return isset(get_theme_mods()[$key]) ? get_theme_mods()[$key] : null;
}

// Add Google Tag Manager script to head if there is GTM ID set up
add_action( 'wp_head', 'head_google_tag_manager' );
function head_google_tag_manager() {
    $gtm_id = get_tag_manager_id();

    if(!$gtm_id)
        return;

    ?>

    <!-- Google Tag Manager -->
    <script type="text/javascript">
        dataLayer = [];
    </script>
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?= $gtm_id ?>');
    </script>
    <!-- End Google Tag Manager -->

    <?php
}

// Add Google Tag Manager noscript to body if there is GTM ID set up
add_action( 'body_start', 'body_google_tag_manager', 0 );
function body_google_tag_manager() {
    $gtm_id = get_tag_manager_id();

    if(!$gtm_id)
        return;

    ?>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$gtm_id?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php
}