<?php
/**
 * Template used to display a single Membership Benefit inside the benefits shortcode defined in shortcodes/membership-benefits.php
 */

$url = get_post_meta($post->ID, 'contact_methods_0_url', true);
if(!strstr($url,'http'))
$url = 'http://' . $url;
?>

<div class="benefit col-xs-12 col-sm-6 col-md-3 col-lg-3">
	<div class="head">
		<?php the_post_thumbnail('full', array('title' => $post->title)); ?> 
	</div>
	<div class="body valign-center">
		<h4 class="subheadline">
			<?php 
			if($url != "")
				echo "<a href=\"{$url}\" target=\"_blank\">{$post->post_title}</a>";
			else
				echo $post->post_title;
			?>
		</h4>
		<p><?php echo get_field('description'); ?></p>
	</div>
</div>