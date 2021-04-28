<?php

/** Shortcode to display info box inside a story. The infobox should
 * be supplied by a shortcode attribute 'caption'. Shortcode also supports attributes: 'class' and 'imageID'.
 *
 * @param array $atts Shortcode attributes defined by the user
 *
 * @return string HTML code of the infobox
 */
function infobox_shortcode( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'float' => 'left',
        'caption' => null,
        'img' => null
    ), $atts );
    $caption = esc_attr($a['caption']);
    $float = esc_attr($a['float']);
    $img = esc_attr($a['img']);
    $image = wp_get_attachment_image( $img, 'medium');

    if (!empty($image)){
        return '<div class="story-infobox ' . $float . '"><div style="width: 100%; padding: 0; margin: 0 0 15px 0;">' . $image . '</div><div class="caption">' . $caption . '</div>' . $content . '</div>';
    }elseif (!empty($caption)){
        return '<div class="story-infobox ' . $float . '"><div class="caption">' . $caption . '</div>' . $content . '</div>';
    }else{
        return '<div class="story-infobox ' . $float . '">' . $content . '</div>';
    }
}
add_shortcode('infobox', 'infobox_shortcode');