<?php
/**
 * Template that defines form to filter available experts.
 *
 * This template is called from shortcodes/expert-fetcher-options.php
 */
?>

<?php if(count($displayExpertFilters) > 0) : ?>
<form method="<?php echo $formMethod; ?>" action="" class="padding-bottom-50">
	<?php foreach ($displayExpertFilters as $filterSlug) : ?>
	<?php 
		if(!isset($expertFilters[$filterSlug]))
			continue;
		$filter = $expertFilters[$filterSlug];
		$inputID = 'expert_filter_'.$filter->slug; 
	?>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<label for="<?php echo $inputID; ?>"><?php echo $filter->name; ?></label>
			<select id="<?php echo $inputID; ?>" name="expert_filters[<?php echo $filter->slug; ?>]">
				<option value="" disabled selected><?php _e("Select a value...", "experts-fetcher"); ?></option>
				<?php foreach( $filter->items as $item) : 
					if($item->count < 1)
						continue;
				?>
					<option value="<?php echo $item->slug; ?>" <?php echo ($item->selected == true) ? 'selected' : ''; ?> > <?php echo $item->name; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endforeach; ?>
	<button type="submit" name="expert_filters_submit" class="page-button-new"><?php _e("Filter experts","experts-fetcher"); ?></button>
	<br>
	<a href="<?php echo get_permalink(); ?>" class="clear-all"><?php _e("Clear filters", "experts-fetcher"); ?></a>
</form>
<?php endif; ?>