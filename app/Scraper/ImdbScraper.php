<?php

namespace Scraper;

/**
 * Scrapes user query from imdb and returns all scraped data
 * @version        2.3
 * @last_modified  10:13 29/01/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @note           seasons and episodes arrays are indexed starting from 1
 */
Class ImdbScraper {
	/**
	 * Property
	 * Contains TV serie details
	 * @var array
	 */
	protected $serie;

	/**
	 * Property
	 * Contains TV series $imdb_id
	 * @var array
	 */
	protected $seriesId;

	/**
	 * Property
	 * Contains stream_context_create object
	 * @var object
	 */
	protected $context;

	/**
	 * Constructor
	 * Initializes context property
	 */
	public function __construct() {
		// Sets context property options
		$options = ["http" => [
			"method"=>"GET",
			"header"=>"Accept-language:en\r\n"
		]];	
		$this->context = stream_context_create($options);
	}

	/**
	 * Gets serie from first result on result page, if any
	 * @param  string   $query User query as serie title
	 * @return string   Contains imdb_id
	 * @return boolean  False when query returned no results
	 */
	public function getSerie($query) {
		// Builds imdb result page url from user request
		$html = file_get_html('http://www.imdb.com/search/title?title='.urlencode($query).'&title_type=tv_series', false, $this->context);

		// Checks results
		$main = $html->find('div#main', 0);
		if (trim($main->plaintext) == "No results.") {
			// Query returned no results
			return false;
		} else {

			// Gets first result from result list
			$tr = $main->find('tr[class=even detailed]', 0);

			// Gets <a> containing serie $title and $imdb_id
			$a = $tr->find('td.title a', 0);
			// $title = $a->plaintext;

			// Gets imdb_id from <a>
			$imdb_id = explode("/", $a->href)[2];

			// Query success
			$this->getSerieById($imdb_id);

			// Return scraped data
			return $this->serie;
		}
	}

	/**
	 * Builds $imdb_id list from imdb most popular series
	 * @return array  Contains imdb ids
	 */
	public function getMostPopularSeriesId() {
		// Empties serieId property
		$this->serieId = null;

		// Gets dom from imdb most popular series result page
		$html = file_get_html('http://www.imdb.com/search/title?title_type=tv_series', false, $this->context);

		// Gets results from dom
		$results = $html->find('table.results td.image');

		// Counts results
		$resultCount = count($results);

		// Includes each result into seriesId property
		for ($i=0; $i<$resultCount; $i++) {

			// Gets $aHref from <a>
			$aHref = $results[$i]->find('a', 0)->href;

			// Gets $imdb_id from $aHref
			$imdb_id = explode("/", $aHref)[2];

			// Includes serie $imdb_id into seriesId property
			$this->seriesId[$i] = $imdb_id;
		}

		// Returs seriesId property
		return $this->seriesId;
	}

	/**
	 * Builds imdb url from user query and scrapes imdb serie details
	 * @param  string   $query User query
	 * @return array    Contains serie infos : title, summary, genre, actors, imdb_id, poster_id, start_date, end_date
	 * @return boolean  True when success, false when query returned no results
	 */
	public function getSerieById($imdb_id) {
		// Empties serie property
		$this->serie = null;

		// Builds idmb query url from $imbd_id and gets imdb dom from imbd_id
		$html = file_get_html("http://www.imdb.com/title/$imdb_id", false, $this->context);

		// Parsing <head><title> gives more consistant results for unknown reason
		$headTitle = $html->find('head title', 0)->plaintext;

		// Gets title
		$title = trim(explode(" (TV Series ", $headTitle)[0]);

		// Gets dates
		$date = explode("–", rtrim(explode(" (TV Series ", $headTitle)[1], ") - IMDb"));

		// Narrows down parsed dom to first <div class="title-overview">
		$divTitleOverview = $html->find('div.title-overview', 0);

		// Gets $posterSrc from <img>
		$posterSrc = $divTitleOverview->find('div.poster img', 0)->src;

		// Gets $poster_id from $posterSrc
		$poster_id = explode("@", explode("/", $posterSrc)[5])[0];

		// gets $summary from first <div class="summary_text">
		$summary = $html->find('div.summary_text', 0)->plaintext;
		$summary = trim($summary);

		// Narrows down parsed dom to all <div class="titleBar"><span itemprop="genre">
		$spanGenres = $html->find('div.titleBar span[itemprop=genre]');
		foreach ($spanGenres as $spanGenre) {
			$genres[] = rtrim(trim($spanGenre->plaintext), " ,");
		}

		// Narrows down parsed dom to all <div class="credit_summary_item"><span itemprop="actors">
		$spanActors = $html->find('div.credit_summary_item span[itemprop=actors]');
		foreach ($spanActors as $spanActor) {
			$actors[] = rtrim(trim($spanActor->plaintext), " ,");
		}

		// Narrows down parsed dom to target <div> (third one)
		$divSeasons = $html->find('div.seasons-and-year-nav div', 2);

		// Finds first <a> to get season total
		$season_count = $divSeasons->find('a', 0)->plaintext;

		// How to build images src from $poster_id :
		// $xxs    = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UY67_CR0,0,45,67_AL_.jpg';
		// $xs     = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1._SY74_CR0,0,54,74_.jpg';
		// $small  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UX67_CR0,0,67,98_AL_.jpg';
		// $medium = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SY317_CR0,0,214,317_AL_.jpg';
		// $large  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SX640_SY720_.jpg';

		$this->serie = [
			"title"      => $title,
			"summary"    => $summary,
			"genre"      => $genres,
			"actors"     => $actors,
			"imdb_id"    => $imdb_id,
			"poster_id"  => $poster_id,
			"start_date" => $date[0],
			"end_date"   => $date[1]
		];

		$this->getSeasons($imdb_id, $season_count);

		// Return scraped data
		return $this->serie;
	}

	/**
	 * Builds imdb season url from $imdb_id, $season_count and sends each episode found to getEpisodeDetails()
	 * @param  string  $imdb_id       id from imdb
	 * @param  integer $season_count  Season count
	 */
	protected function getSeasons($imdb_id, $season_count) {
		// Resets max_execution_time
		ini_set("max_execution_time", 30);

		// For each season
		for ($season=1; $season<=$season_count; $season++) {
			// Builds idmb query url from $imbd_id and $season number
			$html = file_get_html("http://www.imdb.com/title/$imdb_id/episodes?season=$season", false, $this->context);

			// Narrows down parsed dom to target <div> to get season count
			$episodes = $html->find('div#episodes_content div[class=list detail eplist] div.list_item');

			// Initializes $i
			$i = 0;
			// Gets each episode details from season
			foreach ($episodes as $episode) {
				$i++;
				// Sending <div class="list_item odd"> and <div class="list_item even"> to getEpisodeDetails
				$this->getEpisodeDetails($season, $i, $episode);
			}
		}
	}

	/**
	 * Scrapes imdb episodes details
	 * @param  integer     $season   Season
	 * @param  integer     $episode  Episode
	 * @param  dom object  $div      div containing episode details to parse
	 * @return array                 Contains episode details : poster_id, title, imdb_id, summary, air_date
	 */
	protected function getEpisodeDetails($season, $episode, $div) {
		// Gets $poster_src from <img>
		$poster_src = $div->find('img', 0)->src;

		// Gets $poster_id from $poster_src
		$poster_id = explode("@", explode("/", $poster_src)[5])[0];

		// Narrows down parsed dom to target <div class="info">
		$info = $div->find('div.info', 0);

		// Gets $air_date from <div class="airdate">
		$air_date = $info->find('div.airdate', 0)->plaintext;
		$air_date = trim($air_date);

		// Narrows down parsed dom to target <strong><a></a></strong>
		$a = $info->find('strong a', 0);
		$title = $a->plaintext;

		// Gets imdb_id from <a>
		$imdb_id = explode("/", $a->href)[2];

		// Gets episode summary from <div class="item_summary">
		$summary = $info->find('div.item_description', 0)->plaintext;
		$summary = trim($summary);

		$this->serie["seasons"][$season]["episodes"][$episode] = [
			"title"     => $title,
			"summary"   => $summary,
			"air_date"  => $air_date,
			"imdb_id"   => $imdb_id,
			"poster_id" => $poster_id
		];
	}

}