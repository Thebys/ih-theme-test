<?php
/**
 * DEPRECATED: Template for old carousel functionality.
 *
 * TODO: TO be removed. Not sure if it is called from anywhere.
 */
?>

<div id="<?php printf('content-carousel-%s', $posts[0]->ID) ?>" class="carousel slide content-carousel <?php printf('per-row-%s', $per_row) ?>">

	<?php if ( $term ):  ?>
	<h2 class="term-title"><span><?php echo $term->name; ?></span></h2>
	<?php endif; ?>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach ( array_chunk( $posts, $per_page ) as $k => $slide):  ?>
		<div class="item<?php $class = ($k==0) ? _e(' active') : '' ?>">

			<?php foreach( $slide as $post ): setup_postdata( $post ); ?>
			<?php include( locate_template( apply_filters('content_carousel_summary', 'templates/content-summary.php', $post) ) ); ?>
			<?php endforeach; ?>

		</div>
		<?php endforeach; ?>
	</div>

	<?php if ( count($posts) > 1 ): ?>
		<a class="left carousel-control" href="#<?php printf('content-carousel-%s', $posts[0]->ID) ?>" data-slide="prev"><span class="icon-arrow-left"></span></a>
		<a class="right carousel-control" href="#<?php printf('content-carousel-%s', $posts[0]->ID) ?>" data-slide="next"><span class="icon-arrow-right"></span></a>
	<?php endif; ?>
</div>