<?php

namespace Scraper;

/**
 * Scrapes user query from imdb and returns all scraped data
 * @version        1.8
 * @last_modified  09:57 28/01/2016
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
	 * Gets serie from first result on result page, if any
	 * eg: http://www.imdb.com/search/title?title=how%20i%20met%20your%20mother&title_type=tv_series
	 * @param  string   $query User query as serie title
	 * @return string   Contains imdb_id
	 * @return boolean  False when query returned no results
	 */
	public function getSerie($query) {
		// Builds imdb result page url from user request
		$html = file_get_html('http://www.imdb.com/search/title?title='.urlencode($query).'&title_type=tv_series');

		// Checks results
		$main = $html->find('div[id=main]', 0);
		if (trim($main->plaintext) == "No results.") {
			// Query returned no results
			return false;
		} else {

			// Gets first result from result list
			$tr = $main->find('tr[class=even detailed]', 0);

			// Gets <a> containing serie $title and $imdb_id
			$a = $tr->find('td[class=title] a', 0);
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
	 * eg: http://www.imdb.com/search/title?title_type=tv_series
	 * @return array  Contains imdb ids
	 */
	public function getMostPopularSeriesId() {
		// Empties serieId property
		$this->serieId = null;

		// Gets dom from imdb most popular series result page
		$html = file_get_html('http://www.imdb.com/search/title?title_type=tv_series');

		// Gets results from dom
		$results = $html->find('table[class=results] td[class=image]');

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
	 * eg: http://www.imdb.com/search/title?title=how%20i%20met%20your%20mother&title_type=tv_series
	 * @param  string   $query User query
	 * @return array    Contains serie infos : poster_id, title, imdb_id, description, genre, actors
	 * @return boolean  True when success, false when query returned no results
	 */
	public function getSerieById($imdb_id) {
		// Empties serie property
		$this->serie = null;

		// Builds idmb query url from $imbd_id and gets imdb dom from imbd_id
		$html = file_get_html("http://www.imdb.com/title/$imdb_id");

		// Parsing <head><title> gives more consistant results for unknown reason
		$headTitle = $html->find('head title', 0)->plaintext;

		// Gets title
		$title = trim(explode(" (TV Series ", $headTitle)[0]);

		// Gets dates
		$date = explode("–", rtrim(explode(" (TV Series ", $headTitle)[1], ") - IMDb"));

		// Narrows down parsed dom to first <div class="title-overview">
		$divTitleOverview = $html->find('div[class=title-overview]', 0);

		// Gets $posterSrc from <img>
		$posterSrc = $divTitleOverview->find('div[class=poster] img', 0)->src;

		// Gets $poster_id from $posterSrc
		$poster_id = explode("@", explode("/", $posterSrc)[5])[0];

		// // Narrows down parsed dom to first <div class="slate">
		// $trailerHref = $divTitleOverview->find('div[class=slate] a', 0)->href;

		// // Gets $trailer_id from $trailerHref
		// $trailer_id = explode("?", explode("/", $trailerHref)[3])[0];

		// gets $summary from first <div class="summary_text">
		$summary = $html->find('div[class=summary_text]', 0)->plaintext;
		$summary = trim($summary);

		// Narrows down parsed dom to all <div class="titleBar"><span itemprop="genre">
		$spanGenres = $html->find('div[class=titleBar] span[itemprop=genre]');
		$spanCount = count($spanGenres);
		for ($i=0; $i<$spanCount; $i++) {
			$genres[$i] = rtrim(trim($spanGenres[$i]->plaintext), " ,");
			// $genres[] = rtrim(trim($spanGenres[$i]->plaintext), " ,");
		}

		// Narrows down parsed dom to all <div class="credit_summary_item"><span itemprop="actors">
		$spanActors = $html->find('div[class=credit_summary_item] span[itemprop=actors]');
		$spanCount = count($spanActors);
		for ($i=0; $i<$spanCount; $i++) {
			$actors[$i] = rtrim(trim($spanActors[$i]->plaintext), " ,");
		}

		// Narrows down parsed dom to target <div> (third one)
		$divSeasons = $html->find('div[class=seasons-and-year-nav] div', 2);

		// Finds all <a> to get season count
		$season_count = count($divSeasons->find('a'));

		// How to build images src from $poster_id :
		// $xxs    = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UY67_CR0,0,45,67_AL_.jpg';
		// $xs     = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1._SY74_CR0,0,54,74_.jpg';
		// $small  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_UX67_CR0,0,67,98_AL_.jpg';
		// $medium = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SY317_CR0,0,214,317_AL_.jpg';
		// $large  = 'http://ia.media-imdb.com/images/M/'.$poster_id.'@._V1_SX640_SY720_.jpg';

		// How to build trailer src from $trailer_id :
		// $href = 'http://www.imdb.com/video/imdb/'.$trailer_id

		$this->serie = [
			"title"        => $title,
			"summary"      => $summary,
			"genre"        => $genres,
			"actors"       => $actors,
			"imdb_id"      => $imdb_id,
			"poster_id"    => $poster_id,
			// "trailer_id"   => $trailer_id,
			// "season_count" => $season_count,
			"start_date"   => $date[0],
			"end_date"     => $date[1]
		];

		$this->getSeasons($imdb_id, $season_count);

		// Return scraped data
		return $this->serie;
	}

	/**
	 * Builds imdb season url from $imdb_id, $season_count and sends each episode found to getEpisodeDetails()
	 * eg: http://www.imdb.com/title/tt0460649/episodes?season=1
	 * @param  string  $imdb_id       id from imdb
	 * @param  integer $season_count  Season count
	 */
	protected function getSeasons($imdb_id, $season_count) {
		// Resets max_execution_time
		ini_set("max_execution_time", 30);

		// For each season
		for ($season=1; $season<=$season_count; $season++) {

			// Builds idmb query url from $imbd_id and $season number
			$html = file_get_html("http://www.imdb.com/title/$imdb_id/episodes?season=$season");

			// Narrows down parsed dom to target <div> to get season count
			$episode_list = $html->find('div[id=episodes_content] div[class=list detail eplist]', 0);
			$episode_count = count($episode_list->find('div[class=list_item odd]')) + count($episode_list->find('div[class=list_item even]'));
			// $episode_count = count($episode_list->find('div.list_item'));

			// Sets episode_count value into season array
			// $this->serie["seasons"][$season]["episode_count"] = $episode_count;

			// Gets each episode details from season
			for ($j=0; $j<$episode_count*9; $j+=9) {
				// Sets episode index
				$episode = ($j/9)+1;
				$this->getEpisodeDetails($season, $episode, $episode_list->find('div', $j));
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
		$info = $div->find('div[class=info]', 0);

		// Gets $air_date from <div class="airdate">
		$air_date = $info->find('div[class=airdate]', 0)->plaintext;
		$air_date = trim($air_date);

		// Narrows down parsed dom to target <strong><a></a></strong>
		$a = $info->find('strong a', 0);
		$title = $a->plaintext;

		// Gets imdb_id from <a>
		$imdb_id = explode("/", $a->href)[2];

		// Gets episode summary from <div class="item_summary">
		$summary = $info->find('div[class=item_description]', 0)->plaintext;
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