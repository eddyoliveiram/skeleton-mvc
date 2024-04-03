<?php
namespace Core;
$_SESSION['__LAST_QUERIES'] = [];
use PDO;
use PDOException;

class Database {

    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $dbname = 'mrlp';

    protected $dbh;
    protected $stmt;
    protected $error;
    protected $lastQuery;
    protected $currentBinds = [];

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    private function rebuildQueryWithRealValues($query, $binds) {
        foreach ($binds as $param => $value) {
            if (is_string($value)) {
                $value = "'" . addslashes($value) . "'";
            } elseif (is_null($value)) {
                $value = 'NULL';
            } elseif (is_bool($value)) {
                $value = $value ? 'TRUE' : 'FALSE';
            }
            $query = str_replace($param, $value, $query);
        }
        return $query;
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
        $rebuiltQuery = $this->rebuildQueryWithRealValues($this->lastQuery, $this->currentBinds);
        $_SESSION['__LAST_QUERIES'][rand(1,50)] = $rebuiltQuery;
        $this->currentBinds = [];
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
}