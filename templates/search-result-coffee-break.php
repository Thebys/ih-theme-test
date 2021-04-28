<?php
/**
 * Template for a Coffee Break displayed in search results.
 *
 * This template is called from templates/search-result.php
 */

$meta = get_post_meta(get_the_ID(), 'Meta-CB', true)[0];
$link = '/en/space';
if(ICL_LANGUAGE_CODE == 'cs')
    $link = '/prostory';
?>
<div class="post-excerpt">
	<?php 
		printf( 
			'<p>' . __('We will not let you and your guests starve. Our rentals come with a wide range of optional services, including a delicious coffee break from verified suppliers. With this option, refreshment packages start from %s. You can order yours when %s.','roots') . '</p>', 
			$meta['price'], 
			'<a href="' . $link . '">' . __('booking your rental', 'roots') . '</a>'
		);
	?>
</div>