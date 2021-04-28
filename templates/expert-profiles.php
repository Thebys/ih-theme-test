<?php
/**
 * Template defines layout of the filtered experts.
 *
 * This template is called from shortcodes/expert-fetcher-options.php
 */

/** @var $experts array Array of the filtered experts */
?>

<div class="flex-boxes mentoring halign-center">
	<?php if(is_array($experts)) : ?>
	<?php foreach ($experts as $ex) : ?>
	<?php
		$classes = "";
		if(isset($ex->categories['expert_type'])) {
			foreach ($ex->categories['expert_type'] as $type) {
				$classes .= $type->slug . ' ';
			}
		}
	?>
	<div class="team-member <?php echo $classes; ?> col-xs-12 col-sm-6 col-md-3">
		<div class="inner">
			<div class="member-image">
				<?php if($ex->profileImageURL != "") : ?>
					<img data-src="<?php echo $ex->profileImageURL; ?>" alt="<?php echo $ex->fullName; ?>" >
				<?php endif; ?>
				<div class="image-overlay"></div>
			</div>
			<div class="accelerators">
				<?php /*if(isset($ex->categories['expert_accelerator'])) : ?>
					<?php foreach ($ex->categories['expert_accelerator'] as $programme) : ?>
						<a class="programme-icon <?php echo $programme->slug; ?>" 
							data-tooltip="<?php echo $programme->name; ?>" 
							href="<?php echo $programme->description; ?>" 
							target="_blank"></a>
					<?php endforeach; ?>
				<?php endif; */?>
			</div>		
			<div class="member-content">
				<h3><?php 
					echo $ex->fullName; 
					if($ex->linkedin != "") :
					?>
					 | <a href="<?php echo $ex->linkedin; ?>" target="_blank"><i class="icon-linkedin"></i></a>
					<?php endif; ?></h3>
				<p><?php echo $ex->title; ?></p>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php else : ?>
		<p class="none-found padding-top-bottom-30 text-center"><?php _e("No experts found.","experts-fetcher"); ?></p>
	<?php endif; ?>
</div>