<?php
/**
 * DEPRECATED: Template of the search field displayed in the header.
 *
 * TODO: We no longer use search function. Could be removed.
 */
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
	<label class="hide"><?php _e('Search for:', 'roots'); ?></label>
	<input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field form-control" placeholder="<?php _e('Search Impact Hub', 'roots'); ?>">
	<button type="submit" class="search-submit btn btn-default" title="<?php echo __("Search"); ?>"><span><?php echo __("Search"); ?></span><i class="fa fa-search"></i></button>
	<button class="search-close btn btn-default"><i class="fa fa-times"></i></button>
</form>