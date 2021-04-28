<?php
/**
 * Template used to display a Coffee Break post from within the custom Elementor Loop element.
 */

$meta = get_post_meta(get_the_ID(), 'Meta-CB', true)[0];
?>
<div class="toggle-square">

	<div class="toggle-square-head">
		<?php echo get_the_post_thumbnail(null, 'mobile-square'); ?>
	</div>

	<div class="toggle-square-body">
		<div class="toggle-square-text">
			<h2> <?php echo $post->post_title; ?> </h2>
			<span class="price-info">
				<?php echo $meta["price"]; ?>	
			</span>
			<div class="page-button">   
				<a data-toggle="modal" href="#modal-<?php echo $post->post_name; ?>">
					<span class="action icon-eye"></span>
					<span> <?php _e('See more', 'roots') ?> </span> 
				</a>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal-<?php echo $post->post_name; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-close">
					<img src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
				</div>
				<div class="modal-body">
					<div class="image">
						<?php echo get_the_post_thumbnail(null, 'mobile-square'); ?>
					</div>
					<div class="media-body">
						<?php 
							echo $post->post_content; 
							if(isset($meta["comments"]) && $meta["comments"] != "")
								echo '<hr>' . $meta["comments"];
						?>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>