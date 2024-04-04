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

    final public function first() {
        $query = (!$this->db instanceof OracleConnection) ? $this->getFirstDefault() : $this->getFirstOracle();
        $this->db->query($query);
        return $this->db->single();
    }

    protected function getFirstDefault() {
        return "SELECT * FROM $this->table LIMIT 1;";
    }

    protected function getFirstOracle() {
        return "SELECT * FROM (SELECT * FROM $this->table) WHERE ROWNUM = 1";
    }


    final public function firstOracle() {
        $query = "SELECT * FROM (SELECT * FROM $this->table) WHERE ROWNUM = 1";
        $this->db->query($query);
        return $this->db->single();
    }


    final public function getTotal() {
        $this->db->query("SELECT COUNT(*) as count FROM $this->table");
        return $this->db->single()['count'];
    }

}
?>
