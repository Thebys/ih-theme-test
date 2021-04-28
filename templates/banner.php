<?php
/**
 * Template for page banners.
 *
 * TODO: Remove. Banners are no longer used.
 */
?>

<?php do_action('before_page_banner') ?>
<?php $slides = get_field('slide', $banner->ID); ?>
<div id="<?php printf('carousel-%s', $banner->ID) ?>" class="carousel slide <?php echo $type; ?>">
	
	

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach ( (array) $slides as $k => $slide): ?>
		<div class="item<?php $class = ($k==0) ? _e(' active') : '' ?>">
			
			<?php if ( $slide['image_link_url'] ): ?>
			<a href="<?php echo $slide['image_link_url'] ?>">
			<?php endif; ?>

			<div class="image-outer">
				<?php $img_url = ( $size_url = apply_filters( 'banner_image_size', false, $slide['image'], $type ) ) ? $size_url : $slide['image']['url']; ?>
				<img data-src="<?php echo $img_url ?>" alt="<?php echo $slide['image']['title'] ?>">
			</div>

			<?php if ( $slide['image_link_url'] ): ?></a><?php endif; ?>

		</div>
		<?php endforeach; ?>
	</div>

	<?php if ( is_array($slides) && count($slides) > 1 ): ?>
		<!-- Controls -->
		<a class="left carousel-control" href="#<?php printf('carousel-%s', $banner->ID) ?>" data-slide="prev"><span class="icon-arrow-left"></span></a>
		<a class="right carousel-control" href="#<?php printf('carousel-%s', $banner->ID) ?>" data-slide="next"><span class="icon-arrow-right"></span></a>

		<?php if ( $anchor = get_field('anchor_element', $banner->ID ) ): ?>
		<a href="#<?php echo $anchor ?>" class="arrow"><span class="fa fa-angle-down"></span></a>
		<?php endif; ?>
	<?php endif; ?>
	<?php do_action('after_page_banner') ?>
</div>
