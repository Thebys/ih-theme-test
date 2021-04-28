<?php
/**
 * Template of the single post page.
 *
 * This will apply to any post type so displaying single coffee break would use this template. But we don't really want
 * that thus we have the redirection rules set up in lib/redirects.php which makes it impossible to display those pages.
 */

get_template_part('templates/content', 'single' );