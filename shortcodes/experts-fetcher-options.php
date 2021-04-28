<?php

/**
 * Class IHExpertsFetcherOptions Enables configuration of the Experts Fetcher functionality
 */
class IHExpertsFetcherOptions {
	const DATABASE_HOST = "https://experts.impacthub.cz/";
	const CPT_SLUG = "expert";
	const PER_PAGE = 100;
	const DEFAULT_LANGUAGE = 'cs';
	const FORM_METHOD = "GET";
	const TEMPLATE_FORM = "templates/expert-filters.php";
	const TEMPLATE_LIST = "templates/expert-profiles.php";
	const TEMPLATE_MASTER = "templates/expert-master.php";
	const TAXONOMIES_ROUTE = "experts-taxonomy-full";

	const DEFAULT_CONDITIONS = array(
		'per_page' => IHExpertsFetcherOptions::PER_PAGE,
		'page' => 0,
		'orderby' => "title",
		'order' => "asc"
	);
}