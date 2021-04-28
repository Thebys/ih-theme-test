<?php
/**
 * Template of a single search result on the search results page.
 *
 * Template displays different layout according to the post type of the result.
 *
 * This template is called from search.php
 */

$detailUrl = get_permalink();
$type = null;
if($post->post_type == 'tribe_events') {
    if((new DateTime(tribe_get_start_date(null, true, 'Y-m-d', 'Europe/Prague'))) < (new DateTime()))
        $type = __("Passed event", 'roots');
    else
        $type = __("Upcoming event", 'roots');
    if(tribe_event_in_category('ema-zaznam', $post->ID)) {
        $detailUrl = get_field('custom_registration_url');
        $type = __("Event record", 'roots');
    }
}

?>
<div <?php post_class('media col-xs-12 search-result flex-boxes'); ?>>
	<div class="media-object col-xs-12 col-sm-3 col-md-2 valign-center">
		<a href="<?php echo $detailUrl; ?>">
			<?php hub_post_thumbnail('banner-mobile'); ?>
			<?php if($type != null) : ?>
				<span class="content-type"><?php echo $type; ?></span>
			<?php endif; ?>
		</a>
	</div>
	<div class="result-content col-xs-12 col-sm-9 col-md-10 valign-center">
		<h2 class="media-heading">
			<a href="<?php echo $detailUrl; ?>"><?php the_title(); ?></a>
		</h2>
		<?php 
		switch($post->post_type) {
			case 'tribe_events':
				get_template_part('templates/search', 'result-event');
				break;
			case 'space':
				get_template_part('templates/search', 'result-space');
				break;
			case 'coffee_break':
				get_template_part('templates/search', 'result-coffee-break');
				break;
			default:
				get_template_part('templates/search', 'result-default');
				break;
		}
		?>
	</div>
</div>