<?php
/**
 * Functionality for similar stories which would be displayed on the page of a single story.
 *
 * This basically just displays random posts that are not older than 6 months.
 *
 * TODO: This is not used anymore. Could be removed.
 */

//add_action('after_single_content', 'stories_similar_posts', 2);
function stories_similar_posts()
{
	global $post;
	if(!(is_single() && 'post' == get_post_type()))
		return;

	$similarPosts = get_stories_similar_posts($post->ID);

	render_similar_section($similarPosts);
}

function get_stories_similar_posts($curPostID)
{
	$args = array(
		'date_query' => array(
			array(
				'column' => 'post_date_gmt',
				'after' => '12 months ago'
			),
		),
		'post_type' => 'post',
		'posts_per_page' => 4,
        'orderby' => 'date',
        'order'   => 'DESC',
		'post__not_in' => array($curPostID),
		'suppress_filters' => false
	);

	return get_posts($args);
}

function render_similar_section($posts)
{
	echo '<aside class="similar-posts flex-boxes">';
	echo '<div class="headline"><h1>'.__('Trending stories', 'roots').'</h1></div>';
	echo '<div class="flex-boxes similar-posts stories-loop">';
	render_similar_posts($posts);
	echo '</div></aside>';
}

function render_similar_posts($posts)
{
	global $post;
	$activePost = $post;

	foreach ($posts as $key => $simPost) 
	{
		setup_postdata($simPost);
		$post = $simPost;

		get_template_part('templates/content', 'summary');
	}

	setup_postdata($activePost);
	$post = $activePost;
}