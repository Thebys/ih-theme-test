<?php
/**
 * Custom functionality for fetching Impact Hub Experts from main repository.
 *
 * Repository is represented by Experts custom post type on Wordpress website experts.impacthub.cz. Fetching of Experts
 * is handled by default Wordpress REST API. Because we are only fetching items there is no need for authentication.
 */

class IHExpertsFetcher {
	protected $experts;
	protected $filters;
	protected $filterItemsByID;
	protected $language;

	protected $filtersToDisplay;
	protected $presetFilters;

	public function __construct($filtersToDisplay = array('expert_type', 'expert_town', 'expert_accelerator'), $presetFilters = null, $language = IHExpertsFetcherOptions::DEFAULT_LANGUAGE) {
		$this->filtersToDisplay = $filtersToDisplay;
		$this->language = $language;
		$this->fetchFilters();
		$this->presetFilters = array_merge(IHExpertsFetcherOptions::DEFAULT_CONDITIONS, $this->parseFilters($presetFilters));
		$this->fetchResults();
	}

	public function render() {
		ob_start();
		include(locate_template( IHExpertsFetcherOptions::TEMPLATE_MASTER ));
		return ob_get_clean();
	}

	public function renderFilterForm() {
		ob_start();

		$expertFilters = $this->filters;
		$displayExpertFilters = $this->filtersToDisplay;
		$formMethod = IHExpertsFetcherOptions::FORM_METHOD;
		include(locate_template( IHExpertsFetcherOptions::TEMPLATE_FORM ));

		return ob_get_clean();
	}

	public function renderResults() {
		ob_start();

		$experts = $this->experts;
		include(locate_template( IHExpertsFetcherOptions::TEMPLATE_LIST ));

		return ob_get_clean();
	}

	protected function fetchFilters() {
		$jsonData = $this->fetchData(IHExpertsFetcherOptions::TAXONOMIES_ROUTE);
		if(!$jsonData)
			return;
		$data = json_decode($jsonData);
		foreach ($data as $name => $details) {
			$this->filters[$name] = new IHExpertFilter($details->label, $details->name, $details->description);
			$this->filters[$name]->setItems($this->parseItems($details->terms));
		}
	}

	protected function fetchData($queryPath, $args = array()) {
		$url = $this->constructRequestURL($queryPath, $args);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 4);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPGET, 1);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	protected function constructRequestURL($queryPath, $args = null) {
		$requestURL = IHExpertsFetcherOptions::DATABASE_HOST;
		if($this->language != IHExpertsFetcherOptions::DEFAULT_LANGUAGE)
			$requestURL .= $this->language . '/';
		$requestURL .= 'wp-json/wp/v2/' . $queryPath;
		if($args != null && count($args) > 0) {
			$i = 0;
			$argsLength = count($args);
			foreach ($args as $key => $value) {				
				$i++;
				
				if($i == 1)
					$requestURL .= '?';

				if(is_array($value)) {
					$i2 = 0;
					foreach ($value as $v) {
						$i2++;
						$requestURL .= $key.'='.$v;
						if($i2 < count($value))
							$requestURL .= '&';
					}
				} else {
					$requestURL .= $key.'='.$value;
				}

				
				if($i < $argsLength)
					$requestURL .= '&';
			}
		}
		return $requestURL;
	}

	protected function parseItems($rawItems) {
		$items = array();
		foreach ($rawItems as $item) {
			$items[$item->slug] = new IHExpertFilterItem($item->term_id, $item->name, $item->slug, $item->description, $item->count);
			$this->filterItemsByID[$item->term_id] = $items[$item->slug];
		}
		return $items;
	}

	protected function fetchResults() {
		$conditions = $this->parseForm();
		$conditions = array_merge($conditions, $this->presetFilters);
		do {
			$conditions['page']++;
			$roundResults = json_decode($this->fetchData(IHExpertsFetcherOptions::CPT_SLUG, $conditions));
			if(!$roundResults)
				continue;
			foreach ($roundResults as $r) {
				$expert = new IHExpert($r->title->rendered, $r->expert_title, $r->expert_description, $r->expert_thumbnail_url, $r->expert_linkedin);
				$this->assignCategories($expert, $r);
				$this->experts[] = $expert;
			}
		} while(count($roundResults) == IHExpertsFetcherOptions::PER_PAGE);			
	}

	protected function parseForm() {
		$data = $_GET;
		if(IHExpertsFetcherOptions::FORM_METHOD == "POST")
			$data = $_POST;
		if(!isset($data['expert_filters']))
			return array();
		$conditions = array();
		$filters = is_array($data['expert_filters']) ? $data['expert_filters'] : array($data['expert_filters']);
		foreach ($filters as $n => $v) {
			$inputName = htmlspecialchars($n);
			if(!isset($this->filters[$inputName]))
				continue;
			$filter = $this->filters[$inputName];
			$values = is_array($v) ? $v : array($v);
			foreach ($values as $vv) {
				$value = htmlspecialchars($vv);
				if(!isset($filter->items[$value]))
					continue;
				$filter->items[$value]->selected = true;
				$conditions[$filter->slug][] = $filter->items[$value]->id;
			}
		}
		return $conditions;
	}

	protected function assignCategories($expert, $data) {
		foreach ($this->filters as $filter) {
			if(!isset($data->{$filter->slug}))
				continue;
			foreach ($data->{$filter->slug} as $itemID) {
				$expert->categories[$filter->slug][] = $this->filterItemsByID[$itemID];
			}
		}
	}

	protected function parseFilters($args = array()) {
		$presetFilters = array();
		if(!is_array($args))
			return $presetFilters;
		foreach ($args as $key => $value) {
			if(!isset($this->filters[$key]))
				continue;
			$values = explode(',', $value);
			foreach ($values as $item) {
				if(!isset($this->filters[$key]->items[$item]))
					continue;
				$presetFilters[$this->filters[$key]->slug][] = $this->filters[$key]->items[$item]->id;
			}
		}
		return $presetFilters;
	}
}

class IHExpert {
	public $fullName;
	public $title;
	public $decription;
	public $categories;
	public $profileImageURL;
	public $linkedin;

	public function __construct( $fullName, $title, $description, $imgUrl, $linkedin, $categories = null)
	{
		$this->fullName = $fullName;
		$this->title = $title;
		$this->description = $description;
		$this->categories = $categories;
		$this->linkedin = $linkedin;
		$this->profileImageURL = $imgUrl;
	}
}

class IHExpertFilter {
	public $name;
	public $slug;
	public $description;
	public $items;

	public function __construct($name, $slug, $description) {
		$this->name = $name;
		$this->slug = $slug;
		$this->description = $description;
	}

	public function getItems() {
		return $this->items;
	}

	public function setItems($items) {
		$this->items = $items;
	}
}

class IHExpertFilterItem {
	public $name;
	public $slug;
	public $description;
	public $id;
	public $count;
	public $selected;

	public function __construct($id, $name, $slug, $description, $count) {
		$this->id = $id;
		$this->name = $name;
		$this->slug = $slug;
		$this->description = $description;
		$this->count = $count;
		$this->selected = null;
	}
}

add_shortcode( 'experts', 'experts_fetch_shortcode' );
function experts_fetch_shortcode($args = array()) {
	$filters = array();
	if(isset($args['filters']))
		$filters = explode(',', $args['filters']);
	$expertFetcher = new IHExpertsFetcher($filters, $args, isset($args['lang']) ? $args['lang'] : 'cs');
	return $expertFetcher->render();
}