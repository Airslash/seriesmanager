<?php

namespace Manager;

class LastInsertManager extends \W\Manager\Manager
{
	public function lastId()
    {
        return $this->dbh->lastInsertId();
    }
}