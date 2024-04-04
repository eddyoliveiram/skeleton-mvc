<?php
namespace App\Models;

use App\Core\Basic\Model;
use App\Core\Database\PostgreSQLConnection;

class ProfessorModel extends Model
{
    protected $table = 'professors';

    public function __construct() {
        $db = new PostgreSQLConnection();
        parent::__construct($db, $this->table);
    }

}
