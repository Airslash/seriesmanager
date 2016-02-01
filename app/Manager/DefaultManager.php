<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * DefaultManager
 * 
 * Extends W framework Manager with cool new functionalities
 * 
 * @version        1.1.2 beta
 * @last_modified  17:04 30/01/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class DefaultManager extends Manager {

	/**
	 * lastId
	 * 
	 * Retrieves id from last inserted element
	 *
	 * @version                1.0 beta
	 * @see     Manager::$dbh  Uses dbh property from Manager class
	 * @return  integer        Last inserted object primary key
	 */
	public function lastId() {
		return $this->dbh->lastInsertId();
    }

	/**
	 * superSearch
	 * 
	 * Finds all lines containing $query string into target table and column
	 *
	 * @version                   1.2 beta
	 * @see     Manager::$table   Gets target table from Manager class property
	 * @param   string   $search   Text search
	 * @param   string   $column  Target column
	 * @param   string   $table   Optional default is Class name
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function superSearch($search, $column, $table = $this->table) {

		// Searches database for $search into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :search;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':search' => '%' . $search . '%'
			]);

		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			// return $result[0];
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * superFind
	 * 
	 * Finds all lines matching exact $query string into target table and column
	 *
	 * @version                   1.2 beta
	 * @see     Manager::$table   Gets target table from Manager class property
	 * @param   string   $query   Text query
	 * @param   string   $column  Target column
	 * @param   string   $table   Optional default is Class name
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function superFind($query, $column, $table = $this->table) {

		// Searches database for $query into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :query;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':query' => $query
			]);

		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			// return $result[0];
			return $result;
		} else {
			return false;
		}
	}
}