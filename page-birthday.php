<?php
/**
 * Template Name: Birthday page
 *
 * DEPRECATED: Ostrava specific template for a birthday page.
 *
 * TODO: Remove.
 */
?>
<?php while (have_posts()) : the_post(); ?>
	<div class="container flex-boxes halign-center padding-bottom-50 padding-top-50 valign-center birthday-intro">
		<span class="hashtag">Folklórní narozeninová párty</span>
		<span class="date">22. 11. 2018 | 19:30</span>
		<span class="location">Impact Hub Ostrava</span>
		<a href="https://www.facebook.com/events/306565496609004/" target="_blank" class="page-button-new">Facebook</a>
	</div>
	<?php the_content(); ?>
<?php endwhile; ?>