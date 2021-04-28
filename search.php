<?php
/**
 * Template of the search results page.
 */
?>

<div class="container search-page">
	<div class="contained-row">
		<div class="headline padding-bottom-50">
		<?php if ( have_posts() ) : ?>
			<h1><?php printf( __( 'Search results for: %s', 'roots' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php else : ?>
			<h1><?php _e( 'Nothing Found', 'roots' ); ?></h1>
		<?php endif; ?>
			<?php get_search_form(); ?>
		</div>
	</div>

	<?php do_action('before_loop'); ?>
	<?php if ( have_posts() ) : ?>
	<div class="contained-row search-results">
		<?php while ( have_posts() ) {
			the_post();
			get_template_part('templates/search', 'result');
		}
		?>
	</div>
	<?php endif; ?>
	<?php do_action('after_loop'); ?>
</div>
