<?php
/**
 * Template for the single Story layout.
 *
 * The template is called from /single.php.
 */

/** @var WP_Post $post Event to be displayed */
?>

<?php while (have_posts()) : the_post(); ?>
    <?php if(!get_field('new_page_intro')): ?>
        <?php //get_template_part('templates/content', 'feature-top'); ?>
        <div class="page-intro" style="margin-top: 0 !important;">
            <div class="page-intro-bglayer bg-white"></div>
            <div class="contained-row page-headline">
                <h1><?= $post->post_title ?></h1>
                <h5><?php echo apply_filters('feature_meta', '') ?></h5>
            </div>
        </div>
    <?php endif; ?>
    <div class="contained-row">
            <div class="flex-boxes">
                <div class="col-xs-12 col-md-9 padding-bottom-30">
                    <div class="event-details bg-light-grey">
                        <div class="icons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank" class="facebook" anec="single-story" anea="social-share-facebook">
                                <i class="icon icon-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>" target="_blank" class="twitter" anec="single-story" anea="social-share-facebook">
                                <i class="icon icon-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>" target="_blank" class="linkedin" anec="single-story" anea="social-share-facebook">
                                <i class="icon icon-linkedin"></i>
                            </a>
                        </div>                  
                        <div class="description">
                            <?php the_content() ?>
                        </div>
                        <a href="<?= get_permalink( get_option( 'page_for_posts' ) ); ?>" target="" class="page-button-new back-to-posts" anec="single-story" anea="back-to-stories"><?= __('Back to all posts', 'roots'); ?></a>
                    </div>                   
                </div>
                <div class="col-xs-12 col-md-3 padding-bottom-30">
                    <?php
                    get_template_part('templates/story-sidebar');
                    ?>
                </div>
            </div>
        </div>
    
    <?php do_action('after_single_content') ?>
    
    <?php echo service_tiles([ 'anec' => 'singe-detail' ]); ?>
	
<?php endwhile; ?>