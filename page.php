<?php
/**
 * Template of any static page.
 */
?>

<?php while (have_posts()) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>