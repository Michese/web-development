<?php

namespace App\Repository;

use PDO;
use PDOException;

class BaseRepository
{
    protected PDO $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new PDO(
                'mysql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'],
                $_ENV['DATABASE_USER'],
                $_ENV['DATABASE_PASSWORD']
            );
        } catch (PDOException $e) {
            print "Has errors: " . $e->getMessage();
            die();
        }
    }
}
