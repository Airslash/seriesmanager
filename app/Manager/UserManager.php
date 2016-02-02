<?php

namespace Manager;

// classe de base du framework

class UserManager extends \W\Manager\UserManager
{
	public function collection() {

		$sql = "INSERT INTO bookmarks (user_id, serie_id) VALUES ($w_user);";
		$statement = $pdo->prepare($sql);
		$statement->execute([$_GET["id"]]);
	}
}