<?php

namespace Manager;

class SerieManager extends \W\Manager\Manager
{
	public function search()
	{

		$keyword = $_GET['keyword-input'];

		$sql = "SELECT id, title FROM series 
				WHERE title LIKE ?";
		
		$statement = $this->dbh->prepare($sql);
		$statement->execute([':keyword' => '%' . $kw . '%']);
		$series = $statement->fetchAll();

		foreach($series as $serie){
		?>
			<a href="#<?= $serie['id'] ?>" title="<?= $serie['title'] ?>"></a>
		<?php
		}
		?>
		
	}
}