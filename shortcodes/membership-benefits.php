<?php
/**
 * This file defines multiple shortcodes that display partner offers for members.
 */

/**
 * Shortcode that displays all benefits separated into their categories.
 */
function all_benefits_loop($args)
{
	try
	{
		$TAXONOMY = 'partner_categories';
		$POST_TYPE = 'partner'; 

		if(is_admin())
			return;
		$term = validate_term($args['category'],$TAXONOMY);
		$childTerms = get_term_children((int)$term->term_id,$TAXONOMY);

		if(is_wp_error($childTerms) || count($childTerms) <= 0)
			throw new Exception("No child terms found!");

		$output = ""; 
		foreach ($childTerms as $childTerm) {
			$output .= benefits_loop(array('category' => get_term_by('id',$childTerm,$TAXONOMY)->slug));
		}
		return $output;
	}
	catch(Exception $ex)
	{
		wp_mail(get_option('admin_email'), "Chyba na webu " . get_option('blog_name'), $ex);
	}
}
add_shortcode('benefits-category-recursive-loop', 'all_benefits_loop');

/**
 * Shortcode that displays benefits from a single category.
 */
function benefits_loop($args)
{
	$TAXONOMY = 'partner_categories';
	$POST_TYPE = 'partner'; 
	
	if(is_admin())
		return;

	$term = validate_term($args['category'],$TAXONOMY);
	if(!$term)
		throw new Exception("This category does not exist!");
	$query = prepare_query($POST_TYPE, $TAXONOMY, $term->slug);

	ob_start();
	render_membership_benefits($query, $term);
	$output = ob_get_clean();

	return $output;
}
add_shortcode('benefits-category-loop', 'benefits_loop');

/**
 * Validates whether a category exists.
 */
function validate_term($cat, $taxonomy)
{
	if(!$cat)
	{
		throw new Exception("Please fill category attribute!");
		return false;
	}
	$term = get_term_by( 'slug' , $cat, $taxonomy );
	if(!$term)
	{
		throw new Exception("Category \"{$cat}\" doesn't exist!");
		return false;
	}

	return $term;
}

/**
 * Creates an arguments array and a query based on those arguments.
 */
function prepare_query($cpt, $tax, $cat)
{
	$queryArgs = array(
		'post_type' => $cpt,
		'tax_query' => array(
			array(
				'taxonomy' => $tax,
				'field'    => 'slug',
				'terms'    => $cat,
			)
		),
		'orderby' => 'title',
		'order' => 'ASC',
		'posts_per_page' => -1
	);

	return new WP_Query( $queryArgs );	
}

/**
 * Loops through the fetched benefits and renders them.
 */
function render_membership_benefits(&$query, &$term)
{
	if(!$query->have_posts())
		return;

	echo '<div class="benefits flex-boxes col-xs-12">';

	render_benefits_headline($term);

	global $post;
	$globalPost = $post;

	while ($query->have_posts()) {
		$query->the_post();
		render_benefit();
	}

	echo '</div>';

	setup_postdata($globalPost);
	$post = $globalPost;
}

/**
 * Renders a single benefit by loading appropriate template
 */
function render_benefit()
{
	get_template_part('templates/content', 'benefit');
}

/**
 * Renders a HTML element with the benefit category name as a headline
 */
function render_benefits_headline(&$term)
{
	echo "<div class=\"col-xs-12 page-headline smallest\">";
	echo "<h3>{$term->name}</h3>";
	echo "</div>";
}

