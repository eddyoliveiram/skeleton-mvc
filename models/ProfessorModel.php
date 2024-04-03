<?php
namespace Models;

use Core\Database;
use Core\Model;

class ProfessorModel extends Model
{
    protected $table = 'professors';

    public function __construct() {
        parent::__construct($this->table);
        $this->db = new Database();
    }

}
