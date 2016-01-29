<?php

namespace Manager;

class SerieManager extends \W\Manager\Manager
{

	/**
	 * @return string  Le titre de la série
	 * @version v1.0
	 * @last_modified  11:25 29/01/2016
	 */
	public function search()
	{

		$keyword = $_GET['keyword'];

		$sql = "SELECT id, title FROM series 
				WHERE title LIKE :keyword";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $keyword . '%']);
		$series = $statement->fetchAll();

		return $series;
	}
}