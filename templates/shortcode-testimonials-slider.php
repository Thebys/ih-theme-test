<?php
/**
 * Template for the Testimonials slider shortcode.
 *
 * This template is called from shortcodes/testimonials.php
 */

/** @var array $testimonials Array of WP_Post objects with testimonials to be rendered into the slider */
/** @var array $atts Array of shortcode attributes specified by the user */
?>

<div class="swiper-container swiper-container-horizontal testimonials-slider">
	<div class="swiper-wrapper">
		<?php foreach ($testimonials as $testimonial): ?>
			<div class="swiper-slide">
				<?php
				set_query_var('testimonial', $testimonial);
				get_template_part('templates/shortcode-testimonial');
				?>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="swiper-button-prev" anec="<?= $atts['anec'] ?>" anea="prev-testimonial" aria-label="Previous slide" aria-disabled="true">
        <i class="fa fa-arrow-left <?= $atts['arrow_background'] . ' ' . $atts['arrow_color'] ?>"></i>
	</div>
	<div class="swiper-button-next" anec="<?= $atts['anec'] ?>" anea="next-testimonial" aria-label="Next slide" aria-disabled="false">
        <i class="fa fa-arrow-right <?= $atts['arrow_background'] . ' ' . $atts['arrow_color'] ?>"></i>
	</div>
</div>