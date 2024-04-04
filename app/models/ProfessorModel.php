<?php
namespace App\Models;

use App\core\Database;
use App\core\Model;

class ProfessorModel extends Model
{
    protected $table = 'professors';

    public function __construct() {
        parent::__construct($this->table);
        $this->db = new Database();
    }

}
