<?php

namespace App\Core\Database;

use PDO;
use PDOException;

class OracleConnection implements DatabaseInterface {
    private $dbh;
    private $stmt;

    public function __construct() {
        $this->connect();
    }

    function connect() {
        $config = require __DIR__.'/../../../db_config.php';
        $banco = $_SESSION['__BANCO_INTRANET'];
        $oracle =  $config['Oracle'][$banco];

        if (!isset($oracle)) {
            throw new \Exception("Configuração de banco de dados Oracle não encontrada.");
        }

        try {
            $this->dbh = new PDO($oracle['dsn'], $oracle['user'], $oracle['pass']);
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
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            print_r($e->getMessage());die();
            throw new \Exception("Execution failed: " . $e->getMessage());
        }
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function numRows() {
        return $this->stmt->rowCount();
    }

    public function close() {
        $this->stmt = null;
        $this->dbh = null;
    }

    public function getPaginationQuery($table, $page, $itemsPerPage)
    {
        $start = ($page - 1) * $itemsPerPage;
        $end = $start + $itemsPerPage;
        $sql = "SELECT * FROM (
                SELECT *, ROW_NUMBER() OVER () AS row_num FROM $table
           ) WHERE row_num > :start AND row_num <= :end";

        $this->query($sql);
        $this->bind(':start', $start, PDO::PARAM_INT);
        $this->bind(':end', $end, PDO::PARAM_INT);

        return $this->resultSet();
    }
}


