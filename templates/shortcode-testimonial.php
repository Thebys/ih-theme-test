<?php
/**
 * Template for the single Testimonal shortcode.
 *
 * This template is called from shortcodes/testimonials.php
 */

/** @var WP_Post $testimonial WP_Post object of the testimonial to be rendered */
/** @var array $atts Array of shortcode attributes specified by the user */
?>

<div class="testimonial-wrapper <?= !empty($atts['wrapper_class']) ? $atts['wrapper_class'] : '' ?>">
	<div class="testimonial text-center">
		<?php if($atts['photo']): ?>
			<img data-src="<?= get_the_post_thumbnail_url($testimonial->ID) ?>" class="tm-image" alt="<?= get_field('name', $testimonial->ID) ?>">
		<?php endif; ?>
		<p class="tm-text"><?= get_field('description', $testimonial->ID) ?></p>
		<?php if(get_field('name', $testimonial->ID)): ?>
			<p class="tm-name padding-bottom-30">
				<span><?= get_field('name', $testimonial->ID) ?></span><!--
            --><?php if(get_field('title', $testimonial->ID)): ?><!--
                -->, <?= get_field('title', $testimonial->ID) ?>
				<?php endif; ?>
			</p>
		<?php endif; ?>
		<?php if(get_field('button_text', $testimonial->ID)): ?>
			<a href="<?= get_field( 'button_link', $testimonial->ID ) ?>"
               class="page-button-new <?= !empty($atts['button_class']) ? $atts['button_class'] : '' ?>"
               anec="<?= !empty($atts['anec']) ? $atts['anec'] : '' ?>" anea="testimonial-<?= $testimonial->post_name ?>-click">
				<?= get_field( 'button_text', $testimonial->ID ) ?>
			</a>
		<?php endif; ?>
	</div>
</div>