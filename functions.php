<?php

/***************************************************
 * CONTENT TYPES
 * Create custom post types and set them up
 */
require_once locate_template('/lib/content-types/content-types.php');

/***************************************************
 * SHORTCODES
 * Adds custom shortcodes to print dynamic content or repeating elements in pages
 */
require_once locate_template('/shortcodes/shortcodes.php');

/***************************************************
 * REDIRECTS
 * Custom redirects of various custom post types
 */
require_once locate_template('/lib/redirects.php');

/***************************************************
 * SLIDESLIVE
 * Adds integration with SlidesLive API.
 * Also introduces shortcode to display SlidesLive videos in pages
 */
require_once locate_template('/lib/slides-live.php');

/***************************************************
 * POST SYNDICATION
 * Modifies behavior of syndication plugin
 */
require_once locate_template('/lib/post-syndication.php');

/***************************************************
 * WELCOME SESSIONS
 * Adds functionality to generate welcome session dates and insert them into Gravity Forms
 */
require_once locate_template('/lib/welcome-sessions.php');

/***************************************************
 * GRAVITY FORMS
 * Modify Gravity Forms behavior and extend it with some more features
 */
require_once locate_template('/lib/gravity-forms/gravity-forms.php');

/***************************************************
 * IMPACT HUB STATISTICS
 * Modify Gravity Forms behavior and extend it with some more features
 */
require_once locate_template('/lib/impact-hub-statistics.php');

/***************************************************
 * SEARCH
 * Include algorithm that will include meta fields in search which makes us able to search through
 * coffee breaks ingredients, price and many more custom fields of various post types (also includes SEO descriptions)
 */
require_once locate_template('/lib/improve-search.php');

/***************************************************
 * JOB OPPORTUNITIES
 * Adds custom fields for job opportunities pages. Not currently in use.
 */
require_once locate_template('/lib/job-opportunities.php');


/***************************************************
 * ONE-OFFS
 * Scripts used for maintenance of data transformations
 */
require_once locate_template('/lib/oneoffs.php');


/***************************************************
 * UTILITIES
 * Helper functions
 * To be removed soon
 */
require_once locate_template('/lib/utils.php');


/***************************************************
 * WRAPPER
 * Wrapper that loads proper template according to viewed page/post/whatever
 */
require_once locate_template('/lib/wrapper.php');


/***************************************************
 * NAVIGATION WALKER
 * Modifies the way how primary menu is rendered
 */
require_once locate_template('/lib/nav.php');


/***************************************************
 * WIDGETS & SIDEBARS
 * Register custom widgets and sidebars. Currently used only for purposes of footer.
 */
require_once locate_template('/lib/widgets.php');


/***************************************************
 * SCRIPTS
 * Custom CSS & JS handling
 */
require_once locate_template('/lib/scripts.php');


/***************************************************
 * CUSTOM MODIFICATIONS
 * Many various modifications ranging from CSS class modifications, through excerpt modification to theme initialization.
 */
require_once locate_template('/lib/custom.php');


/***************************************************
 * ELEMENTOR
 * Integrate and customize Elementor page builder
 */
require_once locate_template('/lib/elementor/elementor.php');

/***************************************************
 * NOTIFICATIONS
 * Notification display functionality
 */
require_once locate_template('/lib/notifications.php');

/***************************************************
 * EVENTS REST API
 * Functionality for events automation through Google Forms
 */
require_once locate_template('/lib/events-rest-api.php');

/***************************************************
 * CALENDAR
 * Custom calendar functionality to rework the calendar page and event detail
 */
require_once locate_template('/lib/calendar.php');

/***************************************************
 * GOOGLE REVIEWS
 * Functionality to display Google Reviews
 */
require_once locate_template('/lib/google-reviews.php');

/***************************************************
 * CUSTOMIZER
 * Register options for theme customizer
 */
require_once locate_template('/lib/customizer.php');
