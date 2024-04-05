<?php
namespace App\Core\Basic;

use App\Core\Database\DatabaseInterface;
use App\Core\Database\OracleConnection;
use PDO;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct(DatabaseInterface $db, $table = null) {
        $this->db = $db;
        if (!is_null($table)) {
            $this->table = $table;
        } else {
            $this->setTableName();
        }
    }

    protected function setTableName() {
        $className = get_called_class();
        $className = basename(str_replace('\\', '/', $className));
        $this->table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', str_replace('Model', '', $className))) . 's';
    }

    final public function insert($data) {
        if (!empty($data) && is_array($data)) {
            $fields = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO $this->table ($fields) VALUES ($placeholders)";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
            return $this->db->execute() ? true : false;
        } else {
            return false;
        }
    }


    final public function update($data, $id, $idColumn = 'id') {
        if (!empty($data) && is_array($data)) {
            $setParts = [];
            foreach ($data as $key => $value) {
                $setParts[] = "$key = :$key";
            }
            $setClause = implode(', ', $setParts);
            $query = "UPDATE $this->table SET $setClause WHERE $idColumn = :id";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
            $this->db->bind(':id', $id);
            return $this->db->execute() ? true : false;
        } else {
            return false;
        }
    }

    final public function delete($id, $id_Column = 'id') {
        $query = "DELETE FROM $this->table WHERE $idColumn = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute() ? true : false;
    }

    final public function show($id, $idColumn = 'id') {
        $query = "SELECT * FROM $this->table WHERE $idColumn = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    final public function rawQuery($rawQuery) {
        $this->db->query($rawQuery);
        return $this->db->resultSet();
    }

    final public function all() {
        $query = "SELECT * FROM $this->table";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    final public function first() {
        $query = (!$this->db instanceof OracleConnection) ? $this->getFirstDefault() : $this->getFirstOracle();
        $this->db->query($query);
        return $this->db->single();
    }

    protected function getFirstDefault() {
        return "SELECT * FROM $this->table LIMIT 1;";
    }

    protected function getFirstOracle() {
        return "SELECT * FROM (SELECT * FROM $this->table) WHERE ROWNUM = 5";
    }


    final public function countAll() {
        $this->db->query("SELECT COUNT(*) as count FROM $this->table");
        return $this->db->single()['count'];
    }

    final public function paginateAll($page = 1, $itemsPerPage = 15) {
        $query = $this->db->getPaginationQuery($this->table, $page, $itemsPerPage);
        $this->db->query($query);
        $this->db->bind(':start', ($page - 1) * $itemsPerPage, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }


}
?>
