<?php

namespace classes;

use PDO;
use PDOException;

class DbConnector {

    private static $host = "localhost";
    private static $dbname = "gymnsb";
    private static $dbuser = "root";
    private static $dbpassword = "";

    public static function getConnection() {
        try {
            $dataSourceName = "mysql:host=" . self::$host . ";dbname=" . self::$dbname;
            $con = new PDO($dataSourceName, self::$dbuser, self::$dbpassword);
            return $con;
        } catch (PDOException $exc) {
            die("Error in database connection !" . $exc->getMessage());
        }
    }

}
