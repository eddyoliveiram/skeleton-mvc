<?php
namespace App\Core\Database;

use PDO;
use PDOException;

class PostgreSQLConnection implements DatabaseInterface {
    private $dbh;
    private $stmt;

    public function __construct($server = "Producao") {
        $this->connect($server);
    }

    function connect($server) {
        return false;

        try {
            $this->dbh = new PDO($dsn, $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
        $this->lastQuery = $sql;
        $this->currentBinds = [];
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
        $this->currentBinds[$param] = $value;
    }

    public function execute() {
        $result = $this->stmt->execute();
        return $result;
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginationQuery($table, $page, $itemsPerPage) {
        $start = ($page - 1) * $itemsPerPage;
        return "SELECT * FROM $table LIMIT :itemsPerPage OFFSET :start";
    }
}
