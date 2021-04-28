<?php
/**
 * Functionality to fetch & display SlidesLive videos.
 *
 * SlidesLive class handles fetching the videos from the SlidesLive API once a day. The last time of fetching is stored
 * in wp_options table. Apart from fetching the data, the class also enables displaying of the videos either one by one or
 * selected number of them.
 *
 * The functionality is currently used only on the Stories page where we always display one story and one video.
 */

//shortcode implementation
function mashup_loop($atts)
{
	if(!isset($atts['order_by']) && !isset($atts['count']))
		return "Missing arguments.";

	$orderBy = $atts['order_by'];
	$count = $atts['count'];

	global $wpdb;
	$admin = get_option('admin_email');
	// this line differs city by city
	$slidesLive = new SlidesLive($admin, $count, "https://slideslive.com/api/v1/users/impact-hub-praha", $wpdb, $orderBy);

	ob_start();

	if (!$slidesLive->renderSlides()) 
	{
		wp_mail($admin, 'Nepodařilo se načíst prezentace Mashupu', "Chyba při výpisu mashupu z DB");
		return "Failed to render SlidesLive.";
	}

	$code = ob_get_contents();
	ob_end_clean();

	return $code;
}
add_shortcode('mashup_loop', 'mashup_loop');

//class that handles all SlidesLive functionality
class SlidesLive {
	const DATA_TABLE = "wp_slidesLive";
	const REFRESH_OPTION = "slideslive_refresh_date";
	private $adminEmail;
	private $numberOfSlides;
	private $presentations;
	private $channelURL;
	/**
	 * @var wpdb
	 */
	private $db;
	private $orderBy;
	const DESC_REGEX = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
	const DESC_REGEX_2 = "@(www\..+\.(cz|com|net|eu)(/.*)?)@";

	//constructor decides if it requires data update
	//updates data ang gets presentations from database
	// $adminEmail - email for the bug reports
	// $number - number of presentations to render
	// $slidesLiveURL - URL to SlidesLive API
	// $wpdb - WP datatabase object
	// $orderBy - what should be the rendered slides ordered by
	public function __construct($adminEmail, $number, $slidesLiveURL, $wpdb, $orderBy)
	{
		$this->db = &$wpdb;
		$this->adminEmail = $adminEmail;
		$this->channelURL = $slidesLiveURL;
		$this->numberOfSlides = $number;
		$this->orderBy = $orderBy;

		$lastUpdate = $this->getLastUpdate();
		//if data were updated on previous day
		if ($lastUpdate == NULL || $lastUpdate < (new DateTime())->setTime(0,0)) 
		{
			//update data from through SlidesLive API
			$this->getNewData(20);
		} 

		//load slides from database
		$this->loadSlidesLiveData($this->numberOfSlides);
	}

	//return last update timestamp from the database
	function getLastUpdate()
	{
		$value = get_option(self::REFRESH_OPTION);
		if($value != null)
			return (new DateTime($value))->setTime(0,0);
		else
			return null;
	}

	//return 3 random presentations from database
	private function loadSlidesLiveData($count)
	{
		if($this->orderBy == 'asc')
			$order = "id ASC";
		else
			$order = "id DESC";

		if($this->orderBy == 'rand') {
			$cnt = 50;
			if($count > $cnt)
				$cnt = $count;
			$this->presentations = $this->db->get_results("SELECT * FROM (SELECT * FROM " . self::DATA_TABLE . " ORDER BY id LIMIT $cnt) as slideslive_latest ORDER BY RAND() LIMIT $count;", OBJECT);
		} else {
			$this->presentations = $this->db->get_results("SELECT * FROM " . self::DATA_TABLE . " ORDER BY $order LIMIT $count", OBJECT);
		}
	}

	//process data update from SlidesLive
	private function getNewData($presentationCount)
	{
		$APIData = $this->getSlidesLive($presentationCount);

		if (isset($APIData['success']) && isset($APIData['presentations']) && $APIData['success']) {
			//if data were returned successfully, process them and store
			$this->filterData($APIData);
			$this->saveSlidesLive($APIData);
		} else {
			wp_mail($this->adminEmail, 'SlidesLive API nevrátilo prezentace', "V souboru slides-live.php na webu " . get_bloginfo('name') . "
			vrátil server slideslive: " . $APIData);
		}
	}

	//removes presentations that are already in our database from $APIdata array
	private function filterData(&$APIdata)
	{
		$storedPresentations = $this->db->get_results("SELECT id FROM " . self::DATA_TABLE . " ORDER BY id DESC;", OBJECT);
		foreach ($APIdata['presentations'] as $key => $pres) {
			foreach ($storedPresentations as $stored_presentation) {
				if(intval($stored_presentation->id) == $pres['id']) {
					unset($APIdata['presentations'][$key]);
					break;
				}
			}
		}
	}

	//returns N latest presentations from SlidesLive
	private function getSlidesLive($presentationCount)
	{
		// create a new cURL resource
		$ch = curl_init();
		$url = $this->channelURL . "?max_presentations=$presentationCount";

		// Set connection timeouts
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//The query will look like it is an user
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL, $url);
		// Execute
		$result = curl_exec($ch);
		// Closing
		if($result===FALSE)
			wp_mail($this->adminEmail, 'SlidesLive API nevrátilo prezentace', "V souboru slides-live.php na webu " . get_bloginfo('name') . "
			vrátil server slideslive chybu. curl vrátilo chybu: " . curl_error($ch));
		curl_close($ch);
		// Will dump a beauty json :3
		return json_decode($result, true);
	}

	//store presentations in our database
	private function saveSlidesLive(&$APIdata)
	{
		/*
		 * We'll set the default character set and collation for this table.
		 * If we don't do this, some characters could end up being converted
		 * to just ?'s when saved in our table.
		 */
		$charset_collate = '';

		if (!empty($this->db->charset)) {
			$charset_collate = "DEFAULT CHARACTER SET {$this->db->charset}";
		}

		if (!empty($this->db->collate)) {
			$charset_collate .= " COLLATE {$this->db->collate}";
		}

		$sql = "CREATE TABLE IF NOT EXISTS " . self::DATA_TABLE . "
				(
					id int NOT NULL,
					name varchar(256) NOT NULL,
					url varchar(256) NOT NULL,
					thumbnail varchar(256) NOT NULL,
					description text,
					UNIQUE KEY id (id)
				) {$charset_collate};";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		foreach ($APIdata['presentations'] as $pres) {
			$data = array('id' => $pres['id'],
				'name' => $pres['title'],
				'url' => $pres['url'],
				'thumbnail' => $pres['thumbnail'],
				'description' => $this->formatDescription($pres['description'])
			);
			$this->db->insert(self::DATA_TABLE, $data);
		}
		$this->addLastUpdate();

	}

	//insert last update timestamp into database
	private function addLastUpdate()
	{
		update_option(self::REFRESH_OPTION, (new DateTime())->format(DateTime::ATOM));
	}

	//render single presentation
	public function renderSlide($index, $asStory = 0)
	{
		if($index < 0 || $index >= count($this->presentations))
			return;

		$presentation = &$this->presentations[$index];
		if($presentation != NULL)
		{
			$GLOBALS['current_slide'] = $presentation;
			if($asStory != 0)
				get_template_part('templates/content', "slideslive-as-story");
			else
				get_template_part('templates/content', "slideslive");
		}
	}

	//render presentations that are stored in $presentations object 
	public function renderSlides()
	{
		if($this->presentations != NULL)
		{
			echo '<div class="toggle-square-wrapper clearfix">';

			foreach ($this->presentations as $key => $value) 
			{
				$this->renderSlide($key);
			}

			echo '</div>';

			return true;
		}

		return false;
	}

	// Remove URLs and newlines from description
	private function formatDescription($description)
	{
		$description = trim(preg_replace('/\s+/', ' ', $description));
		$description = preg_replace(self::DESC_REGEX, '', $description);
		$description = preg_replace(self::DESC_REGEX_2, '', $description);

		return $description;
	}
}
