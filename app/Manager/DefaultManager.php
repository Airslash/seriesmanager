<?php

namespace Manager;

use \W\Manager\Manager;

/**
 * DefaultManager
 * 
 * Extends W framework Manager with cool new functionalities
 * 
 * @version        1.4
 * @last_modified  14:57 01/02/2016
 * @author         Matthias Morin <matthias.morin@gmail.com>
 * @copyright      2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 */
class DefaultManager extends Manager {

	/**
	 * countRows
	 * 
	 * Counts row from given table
	 *
	 * @see     Manager::$dbh  Uses dbh property from Manager class
	 * @return  integer        Row count
	 */
	public function countRows($table) {
		// Sets default table from Manager class property
		if (empty($table)){
			$table = $this->table;
		}

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
	 * @version                   1.3 beta
	 * @see     Manager::$table   Gets target table from Manager class property
	 * @param   string   $search  Text search
	 * @param   string   $column  Target column
	 * @param   string   $table   Optional default is Class name
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function findLike($search, $column, $table = null) {
		// Sets default table from Manager class property
		if (empty($table)){
			$table = $this->table;
		}

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
	 * @version                   1.3 beta
	 * @see     Manager::$table   Gets target table from Manager class property
	 * @param   string   $query   Text query
	 * @param   string   $column  Target column
	 * @param   string   $table   Optional default is Class name
	 * @return  boolean           False When query returns no result
	 * @return  array             Associative array containig data from database
	 */
	public function findWhere($query, $column, $table = null) {
		// Sets default table from Manager class property
		if (empty($table)){
			$table = $this->table;
		}

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