<?php
/**
 * Template for a Space displayed in search results.
 *
 * This template is called from templates/search-result.php
 */

$capacity = get_field('seating_capacity');
$meta = get_post_meta( get_the_ID(), 'mtg_meta', true )[0];
$link ="";
if(isset($meta["link"]))
    $link =$meta["link"];
?>

<div class="post-excerpt">
	<?php 
		printf( 
			'<p>' . __('Well-designed space at your service! Whether you are planning a meeting, a training session or a public workshop, we will be more than happy to have you. The room capacity is %s seats. Use our %s to book your space.','roots') . '</p>', 
			$capacity, 
			'<a href="' . $link . '">' . __('reservation form', 'roots') . '</a>'
		);
	?>
</div>