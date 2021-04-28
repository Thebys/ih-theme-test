<?php
/**
 * Template for the Photo Slider shortcode.
 *
 * This template is called from shortcodes/photo-slider.php
 */

/** @var WP_Post $slider WP_Post object of the slider to be rendered */
/** @var array $atts Array of shortcode attributes specified by the user */
?>

<?php if(get_field('headline', $slider->ID)): ?>
	<div class="contained-row page-headline smaller">
		<h2 class="fgt-regular"><?= get_field('headline', $slider->ID) ?></h2>
		<p><?= get_field('description', $slider->ID) ?></p>
	</div>
<?php endif; ?>

<?php if( have_rows('photos', $slider->ID) ): ?>
	<div class="swiper-container location-photo-slider swiper-container-horizontal <?= get_field('randomized', $slider->ID) ? 'swiper-randomized' : '' ?>">
		<div class="swiper-wrapper">
			<?php while ( have_rows('photos', $slider->ID) ) : the_row(); ?>

				<div class="swiper-slide">
					<a href="<?= get_sub_field('photo-photo')['url'] ?>" data-lightbox="spaces" data-title="<?= get_sub_field('photo-label') ?>">
						<img data-src="<?= get_sub_field('photo-photo')['sizes']['slider-preview'] ?>" alt="<?= get_sub_field('photo-label') ?>" title="<?= get_sub_field('photo-label') ?>" class="swiper-lazy">
                        <div class="swiper-lazy-preloader swiper-lazy-preloader-black"></div>
					</a>
				</div>

			<?php endwhile; ?>
		</div>
        <div class="swiper-button-prev" anec="<?= $atts['anec'] ?>" anea="prev-photo" aria-label="<?= __('Previous photo', 'roots') ?>" aria-disabled="true">
            <i class="fa fa-arrow-left <?= $atts['arrow_class'] ?>"></i>
        </div>
        <div class="swiper-button-next" anec="<?= $atts['anec'] ?>" anea="next-photo" aria-label="<?= __('Next photo', 'roots') ?>" aria-disabled="false">
            <i class="fa fa-arrow-right <?= $atts['arrow_class'] ?>"></i>
        </div>
	</div>
<?php endif; ?>
