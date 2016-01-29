<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * DefaultManager
 * 
 * Extends W framework Manager with cool new functionalities
 * 
 * @version        1.1
 * @last_modified  16:37 29/01/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class DefaultManager extends Manager {

	/**
	 * lastId
	 * 
	 * Retreives id from last inserted element
	 * 
	 * @return integer  Last inserted objet id
	 */
	public function lastId() {
		return $this->dbh->lastInsertId();
    }

	/**
	 * superFind
	 * 
	 * Searches contained text into table and column
	 * 
	 * @param  string   $table   Target table
	 * @param  string   $column  Target column
	 * @param  string   $search  Text search
	 * @return boolean  False When query returns no result
	 * @return array    Associative array containig data from database
	 */
	public function superFind($table, $column, $search) {

		// Searches database for $search into $column from $table
		$sql = 'SELECT * FROM '.$table.' WHERE '.$column.' = ?;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':keyword' => '%' . $search . '%'
			]);

		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			return $result;
		} else {
			return false;
		}
	}
}