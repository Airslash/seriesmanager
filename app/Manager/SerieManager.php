<?php

namespace Manager;

class SerieManager extends \W\Manager\Manager
{

	/**
	 * @version        1.0.1
	 * @last_modified  11:25 29/01/2016
	 * @author         Axel Merlin <merlin.axel@gmail.com>
	 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
	 * @return         string  Le titre de la série
	 */
	public function search()
	{

		$keyword = $_GET['keyword'];

		$sql = "SELECT id, title, poster_id, start_date FROM series 
				WHERE title LIKE :keyword";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $keyword . '%']);
		$series = $statement->fetchAll();

		return $series;
	}
}