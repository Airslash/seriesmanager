<?php

namespace Manager;

class SerieManager extends \W\Manager\Manager
{
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