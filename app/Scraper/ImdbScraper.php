<?php

namespace Scraper;

/**
 * Scrapes user query from imdb and returns all scraped data
 * @version        1.3
 * @last_modified  21:54 26/01/2016
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
	 * Contains user query
	 * @var string
	 */
	protected $query;

	/**
	 * Class constructor
	 * Sets $query content into $query class property
	 * @param string $query  User query
	 */
	public function __construct($query) {
		$this->query = $query;
	}

	/**
	 * Scrapes user query from imdb and returns all scraped data
	 * @return array Contains all scraped data
	 */
	public function scrape() {
		// Gets $query from $query property
		$query = $this->query;

		// Runs first scraping
		$this->getSerieDetails($query);

		// Gets $imdb_id from serie property
		$imdb_id = $this->serie["imdb_id"];
		// Runs second scraping for season count and additional details
		$this->getSeasonCount($imdb_id);

		// Gets $season_count from serie property
		$season_count = $this->serie["season_count"];

		// Scrapes all season episodes from serie
		$this->getSeasons($imdb_id, $season_count);

		return $this->serie;
	}

	/**
	 * Builds imdb url from user query and scrapes imdb serie details
	 * eg: http://www.imdb.com/search/title?title=how%20i%20met%20your%20mother&title_type=tv_series
	 * @param  string $query User query
	 * @return array  Contains serie infos : poster_id, title, imdb_id, description, genre, actors
	 */
	protected function getSerieDetails($query) {

		// Builds idmb query url from user request
		$html = file_get_html('http://www.imdb.com/search/title?title='.urlencode($query).'&title_type=tv_series');

		// Gets first result from result list
		// Narrows down parsed dom to first <tr>
		$tr = $html->find('tr[class=even detailed]', 0);

		// Gets $poster_src from <img>
		$poster_src = $tr->find('img', 0)->src;

		// Gets $poster_id from $poster_src
		$poster_id = explode("@", explode("/", $poster_src)[5])[0];

		// Gets serie title from <a>
		$a = $html->find('td[class=title] a', 0);
		$title = $a->plaintext;

		// Gets imdb_id from <a>
		$imdb_id = explode("/", $a->href)[2];

		// Gets serie description from first <span>
		$description = $html->find('span[class=outline]', 0)->plaintext;
		$description = trim($description);

		// Gets genre from first <span>
		$genre = $html->find('span[class=genre]', 0)->plaintext;
		$genre = trim($genre);

		// Gets main actors from first <span>
		$actors = $html->find('span[class=credit]', 0)->plaintext;
		$actors = explode("With: ", trim($actors))[1];

		// How to build images src from $poster_id :
		// $xxs    = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UY67_CR0,0,45,67_AL_.jpg';
		// $xs     = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1._SY74_CR0,0,54,74_.jpg';
		// $small  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UX67_CR0,0,67,98_AL_.jpg';
		// $medium = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SY317_CR0,0,214,317_AL_.jpg';
		// $large  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SX640_SY720_.jpg';

		$this->serie = [
			"title"       => $title,
			"description" => $description,
			"genre"       => $genre,
			"actors"      => $actors,
			"imdb_id"     => $imdb_id,
			"poster_id"   => $poster_id
		];
	}

	/**
	 * Builds imdb season url from $imdb_id and scrapes imdb season count, and serie start date and end date
	 * eg: http://www.imdb.com/title/tt0460649/?ref_=fn_al_tt_1
	 * @param  string  $imdb_id  id from imdb
	 * @return array             Season details : $season_count, $start_date, $end_date
	 */
	protected function getSeasonCount($imdb_id) {
		// Builds idmb query url from imbd_id
		$html = file_get_html('http://www.imdb.com/title/'.$imdb_id);

		// Parsing <head><title> gives more consistant results for unknown reason
		$title = $html->find('head title', 0)->plaintext;

		// Gets dates
		$date = explode("–", rtrim(explode(" (TV Series ", $title)[1], ") - IMDb"));

		// Narrows down parsed dom to target <div> (third one)
		$div = $html->find('div[class=seasons-and-year-nav] div', 2);

		// Finds all <a> to get season count
		$season_count = count($div->find('a'));

		$this->serie = array_merge($this->serie, [
			"season_count" => $season_count,
			"start_date"   => $date[0],
			"end_date"     => $date[1]
		]);
	}

	/**
	 * Builds imdb season url from $imdb_id, $season_count and sends each episode found to getEpisodeDetails()
	 * eg: http://www.imdb.com/title/tt0460649/episodes?season=1
	 * @param  string  $imdb_id       id from imdb
	 * @param  integer $season_count  Season count
	 */
	protected function getSeasons($imdb_id, $season_count) {
		// For each season
		for ($i=1; $i<=$season_count; $i++) {
			// Sets $season number
			$season = $i;

			// Builds idmb query url from $imbd_id and $season_count
			$html = file_get_html("http://www.imdb.com/title/$imdb_id/episodes?season=$i");

			// Narrows down parsed dom to target <div> to get season count
			$episode_list = $html->find('div[id=episodes_content] div[class=list detail eplist]', 0);
			$episode_count = count($episode_list->find('div[class=list_item odd]')) + count($episode_list->find('div[class=list_item even]'));

			// Sets episode_count value into season array
			$this->serie["seasons"][$season]["episode_count"] = $episode_count;

			// Gets each episode details from season
			for ($j=0; $j<$episode_count*9; $j+=9) {
				$episode = ($j/9)+1;
				$this->getEpisodeDetails($season, $episode, $episode_list->find('div', $j));
			}
		}
	}

	/**
	 * Scrapes imdb episodes details
	 * @param  integer    $season  Season
	 * @param  integer    $episode Episode
	 * @param  dom object $div     div containing episode details to parse
	 * @return array               Contains episode details : poster_id, title, imdb_id, description, air_date
	 */
	protected function getEpisodeDetails($season, $episode, $div) {
		// Gets $poster_src from <img>
		$poster_src = $div->find('img', 0)->src;

		// Gets $poster_id from $poster_src
		$poster_id = explode("@", explode("/", $poster_src)[5])[0];

		// Narrows down parsed dom to target <div class="info">
		$info = $div->find('div[class=info]', 0);

		// Gets $air_date from <div class="airdate">
		$air_date = $info->find('div[class=airdate]', 0)->plaintext;
		$air_date = trim($air_date);

		// Narrows down parsed dom to target <strong><a></a></strong>
		$a = $info->find('strong a', 0);
		$title = $a->plaintext;

		// Gets imdb_id from <a>
		$imdb_id = explode("/", $a->href)[2];

		// Gets episode description from <div class="item_description">
		$description = $info->find('div[class=item_description]', 0)->plaintext;
		$description = trim($description);

		$this->serie["seasons"][$season]["episodes"][$episode] = [
			"title"       => $title,
			"description" => $description,
			"air_date"    => $air_date,
			"imdb_id"     => $imdb_id,
			"poster_id"   => $poster_id
		];
	}

}