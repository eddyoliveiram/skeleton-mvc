<?php
namespace Models;

use Core\Database;

class UserModel
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function all() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    public function insert($data) {
        if (!empty($data) && is_array($data)) {
            $fields = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO users ($fields) VALUES ($values)";

            $this->db->query($query);

            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }

            return $this->db->execute() ? true : false;
        } else {
            return false;
        }
    }

}