<?php
namespace App\Models;
use App\Core\Basic\Model;
use App\Core\Database\PostgreSQLConnection;

class ProjetoModel extends Model
{
    protected $table = 'projetos.fee_inscritos';

    public function __construct() {
        $db = PostgreSQLConnection::getInstance();
        parent::__construct($db, $this->table);
    }

}
