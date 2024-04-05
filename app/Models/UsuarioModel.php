<?php
namespace App\Models;
use App\Core\Basic\Model;
use App\Core\Database\MySQLConnection;
use App\Core\Database\OracleConnection;
use App\Core\Database\PostgreSQLConnection;

class UsuarioModel extends Model
{
    protected $table = 'projetos.fee_inscritos';

    public function __construct() {
        $db = PostgreSQLConnection::getInstance();
        parent::__construct($db, $this->table);
    }

}
