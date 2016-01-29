<?php

namespace Manager;

/**
 * SerieManager    Manages all requests related to the "series" table
 * @version        1.0
 * @last_modified  14:22 29/01/2016
 * @author         Axel Merlin <merlin.axel@gmail.com>
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class SerieManager extends \W\Manager\Manager {

	/**
	 * search method 
	 * @version        1.0.1
	 * @last_modified  14:27 29/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
 	 * @author         Matthias Morin <matthias.morin@gmail.com>
	 * @return         string  Le titre de la série
	 */
	public function search($keyword) {

		$sql = "SELECT id, title, poster_id, start_date FROM series 
				WHERE title LIKE :keyword";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $keyword . '%']);
		$series = $statement->fetchAll();

		return $series;
	}
}