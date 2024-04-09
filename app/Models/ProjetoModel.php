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

    public function contarUsuarios($attr = null)
    {
        $this->db->query("SELECT COUNT(*) as count FROM $this->table");
        return $this->db->single()['count'];
    }

    public function algumaQueryEspecifica()
    {
        return true;
    }

}
