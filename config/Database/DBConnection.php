<?php

namespace config\Database;

require_once '/laragon/www/phpProject/config/config.php';


class DBConnection {

    public function __construct()
    {
        
    }

    public function connect(): \PDO {
        $db = new \PDO('mysql:dbname=' .DB_NAME . ';host=' .DB_HOST,
        DB_USERNAME,
        DB_PASSWORD
        );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES utf8");
        return $db;
      }
}