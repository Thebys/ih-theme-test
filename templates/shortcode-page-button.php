<?php
/**
 * Template for the Page Button shortcode.
 *
 * Template is ready to be used with or without Elementor. Thanks to the add_render_attribute() method this element
 * can be edited live with Elementor (the changes are visible right away and one can change the button text right
 * in the page itself without interacting with the user interface on the left).
 *
 * This template is called from shortcodes/page-button.php
 */

/** @var array $atts array of shortcode arguments  */

$link_url = $atts['link']['url'];
$new_tab = $atts['link']['is_external'];
$nofollow = $atts['link']['nofollow'];
$modal = $atts['modal'];
$text = $atts['text'];
$anec = $atts['anec'];
$anea = $atts['anea'];
$classes = ['page-button-new'];
if(!empty($atts['size']))
	array_push($classes, $atts['size']);
if(!empty($atts['text_color']))
	array_push($classes, $atts['text_color']);
if(!empty($atts['style']))
    $classes = array_merge($classes, $atts['style']);

/** @var IH_Widget_PageButton $el */
$el = $atts['elementor_widget'];

if($el)
	$el->add_render_attribute(
		'text',
		[
			'class' => $classes,
			'href' => $link_url,
			'target' => $new_tab ? '_blank' : '_self',
			'rel' => $nofollow ? 'nofollow' : '',
            'data-toggle' => $modal ? 'modal' : '',
            'anec' => $anec,
            'anea' => $anea
		]
	)

?>
<a
	<?= $el ? $el->get_render_attribute_string( 'text' ) : '' ?>
	<?= !$el ? 'class="'.join(' ', $classes) . '"' : '' ?>
	<?= !$el ? 'href="' . $link_url . '"' : '' ?>
	<?= !$el ? 'target="' . ($new_tab ? '_blank' : '_self') : '' ?>
	<?= !$el ? 'rel="' . ($nofollow ? 'nofollow' : '') : '' ?>
	<?= !$el ? 'anec="' . ($anec ? $anec : '') : '' ?>
	<?= !$el ? 'anea="' . ($anea ? $anea : '') : '' ?>
	<?= !$el ? 'data-toggle="' . ($modal ? 'modal' : '') : '' ?>
>
	<?= $text ?>
</a>