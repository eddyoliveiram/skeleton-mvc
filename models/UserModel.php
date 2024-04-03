<?php
namespace Models;

use Core\Database;

class UserModel
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function allPaginated($page = 1, $itemsPerPage = 15) {
        $start = ($page - 1) * $itemsPerPage;
        $this->db->query("SELECT * FROM users LIMIT :start, :itemsPerPage");
        $this->db->bind(':start', $start, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function getTotalUsers() {
        $this->db->query("SELECT COUNT(*) as count FROM users");
        return $this->db->single()['count'];
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
