<?php
/**
 * Register sidebars and widgets
 */

function roots_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Left', 'roots'),
        'id'            => 'footer-left',
        'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Center', 'roots'),
        'id'            => 'footer-center',
        'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Right', 'roots'),
        'id'            => 'footer-right',
        'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));

	register_sidebar(array(
		'name'          => __('Footer Bottom', 'roots'),
		'id'            => 'footer-bottom',
		'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'roots_widgets_init');

function get_stories_similar_posts_sidebar($curPostID)
{
    $args = array(
        'date_query' => array(
            array(
                'column' => 'post_date_gmt',
                'after' => '24 months ago'
            ),
        ),
        'post_type' => 'post',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order'   => 'DESC',
        'post__not_in' => array($curPostID),
        'suppress_filters' => false
    );

    return get_posts($args);
}

function render_similar_posts_sidebar($posts)
{
    global $post;
    $activePost = $post;

    foreach ($posts as $key => $simPost)
    {
        setup_postdata($simPost);
        $post = $simPost;
        ?>
        <a href="<?= get_permalink($post) ?>"  anec="story-detail" anea="similar-story">
            <div class="story">
                <span class="title"><?= $post->post_title ?></span>
                <div class="margin-top-15"><?php the_post_thumbnail('medium'); ?></div>
            </div>
        </a>
    <?php }

    setup_postdata($activePost);
    $post = $activePost;
}