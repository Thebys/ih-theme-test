<?php
/**
 * Template used to display a Story from within the custom Elementor Loop element.
 *
 * This template is used on the Stories page. This template is called from home.php
 */

global $post;
global $wp_query;

$detailUrl = get_permalink();
if($post->post_type == 'tribe_events')
	if(tribe_event_in_category('ema-zaznam', $post->ID))
		$detailUrl = get_field('custom_registration_url');

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

$home_layout = !empty($wp_query->query['posts-layout']) && ($wp_query->query['posts-layout'] == 'custom-squares');

?>

<div 
<?php 
if($home_layout)
	post_class('media col-xs-12 col-sm-6 col-md-3');
else
	post_class('media col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
>
	<div class="media-object">
		<a href="<?php echo $detailUrl; ?>">
			<?php 
				if($home_layout) {
					if(($thumb = get_field('homepage_thumbnail')) && $thumb['sizes']['homepage-news']) { ?>
						<img data-src="<?= $thumb['sizes']['homepage-news']; ?>">
					<?php
					} else {
						the_post_thumbnail('homepage-news');
					}
					?>
					<span class="post-type fgt-regular">
						<?= $type_label ?>
						<i class="fa <?= $icon ?> pull-right"></i>		
					</span>
					<?php 
				}
				else
					hub_post_thumbnail('banner-mobile'); 
			?>
		</a>	
	</div>
	<?php if ($type == 'tribe_events' && !isset($hide_location)): ?>
	<?php 
		if(tribe_get_venue() == 'Impact Hub Praha K10') {
			$location = 'k10';
			$bg_color = 'bg-yellow';
		} elseif(tribe_get_venue() == 'Impact Hub Praha D10') {
			$location = 'd10';
			$bg_color = 'bg-mint';
		}
	?>
	<div class="location <?= $location; ?> <?= $bg_color; ?>"><?= tribe_get_venue(); ?></div>
	<?php endif; ?>
	<div class="media-body">
		<h4 class="media-heading ">
			<a href="<?php echo $detailUrl; ?>"><?php the_title(); ?></a>
		</h4>
		<h5 class="post-info">
			<?php if($post->post_type == "tribe_events")
					get_template_part('templates/entry', 'meta') 
			?>
		</h5>
		<?php if($post->post_content)
		{ ?>
		<div class="post-excerpt">
			<?php do_action('hub_excerpt'); ?>
		</div>
		<?php
		} ?>
	</div>
</div>
