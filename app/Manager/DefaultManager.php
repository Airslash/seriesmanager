<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * DefaultManager
 * 
 * Extends W framework Manager with cool new functionalities
 * 
 * @version        1.4.2
 * @last_modified  11:24 02/02/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method         countRows  Counts rows from given table
 * @method         lastId     Retrieves id from last inserted element
 * @method         findLike   Finds all lines containing $query string into target table and column
 * @method         findWhere  Finds all lines matching exact $query string into target table and column
 */
class DefaultManager extends Manager {

	/**
	 * countRows
	 * 
	 * Counts rows from given table
	 *
	 * @see     Manager::$dbh    Uses dbh property from Manager class
	 * @param   string   $table  Table name
	 * @return  integer          Row count
	 */
	public function countRows($table) {
		// Searches database for $search into $column from $table
		$sql = 'SELECT COUNT(*) FROM ' . $table;
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
		return $result[0]["COUNT(*)"];
    }

	/**
	 * lastId
	 * 
	 * Retrieves id from last inserted element
	 *
	 * @see     Manager::$dbh  Uses dbh property from Manager class
	 * @return  integer        Last inserted object primary key
	 */
	public function lastId() {
		return $this->dbh->lastInsertId();
    }

	/**
	 * findLike
	 * 
	 * Finds all lines containing $query string into target table and column
	 *
	 * @param   string   $search  Text search
	 * @param   string   $column  Target column
	 * @param   string   $table   Table name
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function findLike($search, $column, $table) {
		// Searches database for $search into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' LIKE :search;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':search' => '%' . $search . '%'
			]);

		$result = $statement->fetchAll();
		// If fetchAll returned results
		if ( $result ) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * findWhere
	 * 
	 * Finds all lines matching exact $query string into target table and column
	 *
	 * @param   string   $query   Text query
	 * @param   string   $column  Target column
	 * @param   string   $table   Table name
	 * @see     Manager::$dbh     Uses dbh property from Manager class
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function findWhere($query, $column, $table) {
		// Searches database for $query into $column from $table
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :query;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':query' => $query
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