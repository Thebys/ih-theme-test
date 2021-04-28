<?php 
/** Shortcode to display referential badges displayed in web-forms
 *
 * @return string HTML code of the referential badges 
 */
function shortcode_referential_badges() {

    ob_start();
    get_template_part('templates/shortcode-referential-badges');

    return ob_get_clean();
}
add_shortcode( 'badge', 'shortcode_referential_badges' );