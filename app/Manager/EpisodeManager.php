<?php

namespace Manager;

/**
 * EpisodeManager
 *
 * Manages requests to "episodes" table
 *
 * @version                      1.5
 * @last_modified                16:13 02/02/2016
 * @author                       Matthias Morin <matthias.morin@gmail.com>
 * @copyright                    2015-2016 - CAMS Squad, Full Stack Web Developpers Team
 * @method         findEpisodes  Finds serie episodes by season
 */
class EpisodeManager extends \W\Manager\Manager {
	/**
	 * findEpisodes
	 *
	 * Finds serie episodes by season
	 *
	 * @param   integer  $serie_id  Serie primary key
	 * @param   integer  $season    Season number
	 * @see     Manager::$dbh       Uses dbh property from Manager class
	 * @return  boolean             False When query returns no result
	 * @return  array               Associative array containing all episodes
	 */
	public function findEpisodes($serie_id, $season) {
		// Searches database for $query into $column from $table
		$sql = 'SELECT * FROM `episodes` WHERE `serie_id` = :serie_id AND `season` = :season ORDER BY `episode`;';
		$statement = $this->dbh->prepare($sql);
		$statement->execute([
			':serie_id' => $serie_id,
			':season'   => $season,
			]);

		$episodes = $statement->fetch();

		// Shifts array indexes
		foreach ($episodes as $key => $value) {
			$temp[$key+1] = $value;
		}

		$episodes = $temp;

		// If fetchAll returned results
		if ( $episodes ) {
			return $episodes;
		} else {
			return false;
		}
	}
}