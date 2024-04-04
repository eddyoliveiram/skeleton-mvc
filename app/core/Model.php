<?php
namespace App\Core;

use PDO;

class Model extends Database{

    protected $db;
    protected $table;

    public function __construct($table = null) {
        parent::__construct();
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
            $this->query($query);
            foreach ($data as $key => $value) {
                $this->bind(':' . $key, $value);
            }
            return $this->execute() ? true : false;
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
            $this->query($query);
            foreach ($data as $key => $value) {
                $this->bind(':' . $key, $value);
            }
            $this->bind(':id', $id);
            return $this->execute() ? true : false;
        } else {
            return false;
        }
    }

    final public function delete($id, $id_Column = 'id') {
        $query = "DELETE FROM $this->table WHERE $idColumn = :id";
        $this->query($query);
        $this->bind(':id', $id, PDO::PARAM_INT);
        return $this->execute() ? true : false;
    }

    final public function show($id, $idColumn = 'id') {
        $query = "SELECT * FROM $this->table WHERE $idColumn = :id";
        $this->query($query);
        $this->bind(':id', $id, PDO::PARAM_INT);
        return $this->single();
    }

}
?>
