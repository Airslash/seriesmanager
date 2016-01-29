<?php

namespace Manager;

/**
 * SerieManager
 * 
 * Manages all requests related to the "series" table
 * 
 * @version        1.0.1
 * @last_modified  16:26 29/01/2016
 * @author         Axel Merlin <merlin.axel@gmail.com>
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieManager extends \W\Manager\Manager {

	/**
	 * search
	 * 
	 * Searches for id, title, poster_id, start_date into database according to keyword
	 * 
	 * @version                  1.1
	 * @last_modified            17:02 29/01/2016
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
	 * @last_modified        14:27 29/01/2016
	 * @author               Axel Merlin <merlin.axel@gmail.com>
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
	 * getSeasons
	 * 
	 * Gets database serie from imdb reference id
	 * 
	 * @version              1.0 beta
	 * @last_modified        14:27 29/01/2016
	 * @author               Axel Merlin <merlin.axel@gmail.com>
 	 * @author               Matthias Morin <matthias.morin@gmail.com>
	 * @param  integer  $id  element id
	 * @return array         Contains serie data
	 */
	public function getSeasons($id) {

		$sql = "SELECT * FROM series WHERE id = $id";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':id' => $id
			]);

		$seasons = $statement->fetch();

		return $seasons;
	}

	/**
	 * getEpisodes
	 * 
	 * Gets database serie from imdb reference id
	 * 
	 * @version              1.0 beta
	 * @last_modified        14:27 29/01/2016
	 * @author               Axel Merlin <merlin.axel@gmail.com>
 	 * @author               Matthias Morin <matthias.morin@gmail.com>
	 * @param  integer  $id  element id
	 * @return array         Contains serie data
	 */
	public function getEpisodes($id) {

		$sql = "SELECT * FROM series WHERE id = $id";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':id' => $id
			]);

		$seasons = $statement->fetch();

		return $seasons;
	}
}
