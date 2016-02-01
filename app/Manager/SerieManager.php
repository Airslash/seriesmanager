<?php

namespace Manager;

/**
 * SerieManager
 * 
 * Manages all requests related to the "series" table
 * 
 * @version        1.0.2 beta
 * @deprecated     1.0.2 beta
 * @author         Axel Merlin <merlin.axel@gmail.com>
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieManager extends \W\Manager\Manager {

	/**
	 * getEpisode
	 * 
	 * Gets database serie from imdb reference id
	 * 
	 * @version                   1.0 beta
	 * @deprecated                1.0 beta
	 * @author                    Axel Merlin <merlin.axel@gmail.com>
 	 * @author                    Matthias Morin <matthias.morin@gmail.com>
	 * @param  string   $imdb_id  Element imdb_id
	 * @param  integer  $season   Element season number
	 * @return array              Contains serie data
	 */
	public function getEpisode($id, $season, $episode) {


		$sql = "SELECT * FROM series WHERE id = :id AND season = :season AND episode = :episode";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':id'      => $id, 
			':season'  => $season,
			':episode' => $episode,
			]);

		$seasons = $statement->fetch();

		return $seasons;
	}

	/**
	 * search
	 * 
	 * Searches for $keyword into database and returns serie id, title, poster_id, start_date
	 * 
	 * @version                  1.1
	 * @deprecated               1.1
	 * @author                   Axel Merlin <merlin.axel@gmail.com>
 	 * @author                   Matthias Morin <matthias.morin@gmail.com>
	 * @param  string  $keyword  User request
	 * @return arrray            Contains id, title, poster_id, start_date
	 */
	public function search($keyword) {

		$sql = "SELECT id, title, poster_id, start_date FROM series 
				WHERE title LIKE :keyword";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $keyword . '%']);
		$series = $statement->fetchAll();

		return $series;
	}

	/**
	 * getSerie
	 * 
	 * Gets database serie from imdb reference id
	 * 
	 * @version              1.0 beta
	 * @deprecated           1.0 beta
 	 * @author               Matthias Morin <matthias.morin@gmail.com>
	 * @param  integer  $id  element id
	 * @return array         Contains serie data
	 */
	public function getSerie($id) {

		$sql = "SELECT * FROM series WHERE id = $id";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':id' => $id
			]);

		$serie = $statement->fetch();

		return $serie;
	}

	/**
	 * getSeason
	 * 
	 * Gets database serie from imdb reference id and season number
	 * 
	 * @version                   1.0 beta
	 * @deprecated                1.0 beta
 	 * @author                    Matthias Morin <matthias.morin@gmail.com>
	 * @param  string   $imdb_id  Element imdb_id
	 * @param  integer  $season   Element season number
	 * @return array              Contains serie data
	 */
	public function getSeason($imdb_id, $season) {

		$sql = "SELECT * FROM series WHERE imdb_id = :imdb_id AND season = :season";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':imdb_id' => $imdb_id, 
			':season'  => $season,
			]);

		$seasons = $statement->fetch();

		return $seasons;
	}
}