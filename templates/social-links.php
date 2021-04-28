<?php
/**
 * Template for rendering the Social Links defined in the so called section of the administration.
 *
 * Currently used only via in the footer of the website via [social-links] shortcode defined in lib/content-types/social-link.php.
 */
/** @var $links WP_Post[] Array of the social links "posts" */
?>

<div class="social-links">
    <ul>
    	<?php foreach ($links as $link): ?>
        <li style="background: <?php echo get_field('color', $link->ID) ?>; color: <?php echo get_field('color', $link->ID) ?>;">
            <a href="<?php echo get_field('url', $link->ID) ?>" target="_blank" class="<?php echo get_field('icon', $link->ID) ?>">
            	<i class="icon <?php printf('icon-%s', get_field('icon', $link->ID) ) ?>">
            		<span><?php echo $link->post_title ?></span>
            	</i>
        	</a>
        </li>
	    <?php endforeach; ?>
    </ul>
</div>