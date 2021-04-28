<?php
/**
 * DEPRECATED: Template for the banner/carousel functionality used on the beginning of posts and pages.
 *
 * This template is called from templates/content-feature.php
 *
 * TODO: To be removed. But I believe it might still be used by the Single Story layout.
 */

$type_object = get_post_type_object( get_post_type() );
?>
<?php do_action('before_feature_top'); ?>
<div class="media-object feature-top container">
	<?php if( !is_singular('tribe_events') ) echo apply_filters( 'feature_link_start',  sprintf('<a href="%s">', get_permalink() ) ); ?>
	<?php hub_post_thumbnail( 'banner-new' ); ?>

	<?php if( !is_singular('tribe_events') && !is_singular('post')): ?>

        <div class="feature-caption">
            <h3 class="page-title"><?php echo $type_object->labels->singular_name ?></h3>
            <h2 class="post-title"><?php echo get_the_title(); ?></h2>
            <h4 class="post-meta"><?php echo apply_filters('feature_meta', '') ?></h4>
        </div>

	<?php endif; ?>
    </a>

	<?php if( !is_singular('tribe_events') ) echo apply_filters( 'feature_link_end',  '</a>' ); ?>
</div>

<?php do_action('after_feature_top'); ?>
