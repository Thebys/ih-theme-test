<?php
/**
 * Template used to display a Team Member from within the custom Elementor Loop element.
 *
 * TODO: Rename 'new' once you remove the old layout.
 */

global $post;
$roles = get_the_terms($post->ID, 'team_role');
$classes = "";
foreach ($roles as $key => $role) {
    $classes .= $role->slug . ' ';
}
?>
<div class="team-member <?php echo $classes; ?> col-xs-12 col-sm-6 col-md-3">
	<div class="inner">
		<div class="member-image">
			<?php hub_post_thumbnail('mobile-square'); ?>
			<div class="image-overlay"></div>
		</div>
		<div class="member-content">
			<h3> <?php the_title(); ?> </h3>
			<?php if ( $title = get_field('title') ): ?>
				<p>
					<?php echo $title ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
