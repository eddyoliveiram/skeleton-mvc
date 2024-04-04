<?php
namespace App\Models;
use App\Core\Basic\Model;
use App\Core\Database\MySQLConnection;
use App\Core\Database\OracleConnection;
use App\Core\Database\PostgreSQLConnection;

class UsuarioModel extends Model
{
    protected $table = 'fmt.eixos';

    public function __construct() {
        $db = new PostgreSQLConnection();
        parent::__construct($db, $this->table);
    }

    public function allPaginated($page = 1, $itemsPerPage = 15) {
        $query = $this->db->getPaginationQuery($this->table, $page, $itemsPerPage);

        $this->db->query($query);
        $this->db->bind(':start', ($page - 1) * $itemsPerPage, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }

}
