<?php
/**
 * Template used to display a Story from within the custom Elementor Loop element.
 *
 * This template is called from templates/content-summary.php
 */

global $post;
global $wp_query;

$detailUrl = get_permalink();

$type = $post->post_type;
$type_label = get_post_type_object( get_post_type() )->labels->singular_name;

switch ($type) {
	case 'post':
		$icon = 'fa-pencil';
		break;
	case 'tribe_events':
		$icon = 'fa-calendar';
		break;
	default:
		$icon = null;
		break;
}

?>

<div <?php post_class('media col-xs-12 col-sm-6 col-md-3'); ?>>
	<div class="media-object">
		<a href="<?php echo $detailUrl; ?>">
			<?php
				if(($thumb = get_field('homepage_thumbnail')) && $thumb['sizes']['homepage-news']) : ?>
					<img data-src="<?= $thumb['sizes']['homepage-news']; ?>">
				<?php else:
					the_post_thumbnail('homepage-news');
				endif;
				?>
				<span class="post-type fgt-regular">
					<?= $type_label ?>
					<i class="fa <?= $icon ?> pull-right"></i>
				</span>
		</a>
	</div>
	<div class="media-body">
		<h4 class="media-heading ">
			<a href="<?php echo $detailUrl; ?>"><?php the_title(); ?></a>
		</h4>
		<div class="post-excerpt">
			<?php do_action('hub_excerpt'); ?>
		</div>
	</div>
</div>
