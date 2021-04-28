<?php
/**
 * Template for the Section Headline shortcode.
 *
 * Template is ready to be used with or without Elementor. Thanks to the add_render_attribute() method this element
 * can be edited live with Elementor (the changes are visible right away and one can change the headline & text right
 * in the page itself without interacting with the user interface on the left).
 *
 * This template is called from shortcodes/section-headline.php
 */

/** @var array $atts array of shortcode arguments  */

$headline = $atts['headline_text'];
$level = $atts['headline_level'];
$size = $atts['headline_size'];
$intro = $atts['intro_text'];
$fullwidth = $atts['fullwidth'];
$padding = $atts['padding'];

/**  @var IH_Widget_SectionHeadline $el */
$el = $atts['elementor_widget'];

if($el)
    $el->add_render_attribute(
            'headline_text',
            ['class' => 'fgt-regular']
    )

?>
<div class="page-headline <?= $size ?> <?= $fullwidth ? '' : 'contained-row'?> <?= $padding ? 'padding-top-bottom-50' : '' ?>">
	<?php if($headline): ?>
    <<?= $level ?> <?= $el ? $el->get_render_attribute_string( 'headline_text' ) : 'class="fgt-regular"' ?> >
            <?= $headline ?>
    </<?= $level ?>>
    <?php endif; ?>
    <?php if($intro): ?>
	<p <?= $el ? $el->get_render_attribute_string( 'intro_text' ) : '' ?> >
        <?= $intro ?>
    </p>
    <?php endif; ?>
</div>