<?php

/** Shortcode to display MKT message. The shortcode can be suplied with formids parametr.
 *
 * @param array $atts Shortcode attributes defined by the user
 *
 * @return string HTML code of the infobox
 */
function form_count_shortcode( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'formids' => null,
        'daysbefore' => 7,
        'constant' => 1.4,
        'minimum' => 18
    ), $atts );

    if (is_null(esc_attr($a['formids'])) || esc_attr($a['formids'])==""){
        $formids='SELECT id FROM wp_gf_form WHERE is_active=1 and is_trash=0';
    }else{
        $formids=esc_attr($a['formids']);
    }

    $domain = $_SERVER['HTTP_HOST'];

    if ($domain=="new.hubpraha.cz" || $domain=="hubpraha.cz" || $domain=="www.hubpraha.cz"){
        $minimum = 18;
        $daysbefore = 7;
        $constant = 1.4;
    }elseif ($domain=="new.hubbrno.cz" || $domain=="hubbrno.cz" || $domain=="www.hubbrno.cz"){
        $minimum=21;
        $daysbefore = 14;
        $constant = 1.4;
    }elseif ($domain=="new.hubostrava.cz" || $domain=="hubostrava.cz" || $domain=="www.hubostrava.cz"){
        $minimum=26;
        $daysbefore = 30;
        $constant = 1.4;
    }else{
        $minimum = esc_attr($a['minimum']);
        $daysbefore = esc_attr($a['daysbefore']);
        $constant = esc_attr($a['constant']);
    }



    global $wpdb;
    $countquery = $wpdb->get_results("SELECT COUNT(*) as count FROM wp_gf_entry WHERE `date_created` >= NOW() - INTERVAL $daysbefore DAY AND `form_id` IN ($formids)" );
    $realcount = intval($constant * $countquery[0]->count);
    if ($realcount<$minimum){
        $count=$minimum;
    }else{
        $count=$realcount;
    }

    if (ICL_LANGUAGE_CODE == "cs") {
        $mktmessage = sprintf('Za posledních %d dní se o naše služby zajímalo %d návštěvníků.', $daysbefore, $count);
    } elseif (ICL_LANGUAGE_CODE == "en") {
        $mktmessage = sprintf('%d people have been interested in our services last %d days.', $count, $daysbefore);
    } else {
        $mktmessage = sprintf('%d people have been interested in our services last %d days.', $count, $daysbefore);
    }

    return '<div class="mkt-message" style="font-size: 12px; font-family: Open Sans,Helvetica,sans-serif; margin-top: 15px; margin-bottom: 15px;">' .$mktmessage. '</div>';
}
add_shortcode('form-count', 'form_count_shortcode');