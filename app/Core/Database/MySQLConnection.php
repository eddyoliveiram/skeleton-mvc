<?php
namespace App\Core\Database;

use PDO;
use PDOException;

class MySQLConnection implements DatabaseInterface {
    private $dbh;
    private $stmt;
    private $host = "localhost";
    private $user = "root";
    private $password = '';
    private $dbname = 'mrlp';
    private static $instance = null;

    private function __construct() {
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function connect() {

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginationQuery($table, $page, $itemsPerPage)
    {
        $start = ($page - 1) * $itemsPerPage;
        $query = "SELECT * FROM $table LIMIT :start, :itemsPerPage";
        return $query;
    }
}
