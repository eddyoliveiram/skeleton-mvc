<?php
namespace Models;

use Core\Database;

class ProfessorModel
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getById($id) {

        $this->db->query("SELECT * FROM professors WHERE id = :id");
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function all() {
        $this->db->query("SELECT * FROM professors");
        return $this->db->resultSet();
    }
}