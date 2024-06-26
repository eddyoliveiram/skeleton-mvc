<?php
namespace App\Core\Database;

use App\Core\App;
use PDO;
use PDOException;

class PostgreSQLConnection implements DatabaseInterface {
    private static $instance = null;
    private $dbh;
    private $stmt;

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

//        $config = require __DIR__.'/../../../db_config.php';
//        $banco = $_SESSION['__BANCO_INTRANET'];
//        $postgreSQL =  $config['PostgreSQL'][$banco];

        $dsn = "pgsql:host=" . DB_HOST_POSTGRE . ";dbname=" . DB_NAME_POSTGRE;
        $username = DB_USER_POSTGRE;
        $password = DB_PASS_POSTGRE;

        if (!DB_HOST_POSTGRE || !DB_NAME_POSTGRE ) {
            throw new \Exception("Configuração de banco de dados PostgreSQL não definida.");
        }
        try {
//            $this->dbh = new PDO($postgreSQL['dsn'], $postgreSQL['user'], $postgreSQL['pass']);
            $this->dbh = new PDO($dsn, $username, $password);
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

}
