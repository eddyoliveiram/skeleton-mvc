<?php
namespace Models;

use Core\Database;
use Core\Model;

class UserModel extends Model
{
    protected $table = 'users';

    public function __construct() {
        parent::__construct($this->table);
        $this->db = new Database();
    }

    public function allPaginated($page = 1, $itemsPerPage = 15) {
        $start = ($page - 1) * $itemsPerPage;
        $this->db->query("SELECT * FROM $this->table LIMIT :start, :itemsPerPage");
        $this->db->bind(':start', $start, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function getTotalUsers() {
        $this->db->query("SELECT COUNT(*) as count FROM $this->table");
        return $this->db->single()['count'];
    }

}
