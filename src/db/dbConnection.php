<?php

namespace App\Db;

use PDO;
use PDOException;

use App\Errors\DbError;

require_once('errors/dbError.php');

class DbConnection
{
    private static $instance = null;

    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $conn;

    private function __construct()
    {
        $this->servername = "db";
        $this->username = $_ENV['MYSQL_USER'];
        $this->password = $_ENV['MYSQL_PASSWORD'];
        $this->dbname = $_ENV['MYSQL_DATABASE_NAME'];

        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new DbError("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }
}
