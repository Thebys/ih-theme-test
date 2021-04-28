<?php

/*
 * This folder includes single files that define Custom Post Types. Each custom post type is located in a separate file.
 * The structure of the files is usually very similar as it contains definition of the post type, definitiof of taxonomies
 * and definition of additional custom fields (via ACF plugin).
 *
 * Some of the post types might also include custom functionality which is tied to that custom post type. Those parts
 * are commented. The aforementioned definitions of CPTs and fields are not documented as they are straightforward.
 *
 * Relevant docs:
 * https://developer.wordpress.org/reference/functions/register_post_type/
 * https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */

require_once locate_template('/lib/content-types/banner.php');

require_once locate_template('/lib/content-types/event.php');

require_once locate_template('/lib/content-types/notification.php');

require_once locate_template('/lib/content-types/page.php');

require_once locate_template('/lib/content-types/partner.php');

require_once locate_template('/lib/content-types/post.php');

require_once locate_template('/lib/content-types/space.php');

require_once locate_template('/lib/content-types/team.php');

require_once locate_template('/lib/content-types/testimonial.php');

require_once locate_template('/lib/content-types/photo-slider.php');
