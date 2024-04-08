<?php
namespace App\Core\Basic;

use App\Core\Database\DatabaseInterface;
use App\Core\Database\OracleConnection;
use App\Core\Database\PostgreSQLConnection;
use PDO;

class Model {
    protected $db;
    protected $table;
    protected $paginacao;

    public function __construct(DatabaseInterface $db = null, $table = null) {
        if($db != null){
            $this->db = $db;
        }else{
           $this->db = PostgreSQLConnection::getInstance();
        }

        if (!is_null($table)) {
            $this->table = $table;
        } else {
            $this->nomeTabelaAutomatico();
        }
    }

    protected function nomeTabelaAutomatico() {
        $className = get_called_class();
        $className = basename(str_replace('\\', '/', $className));
        $this->table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', str_replace('Model', '', $className))) . 's';
    }

    final public function inserir($data) {
        if (!empty($data) && is_array($data)) {
            $fields = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO $this->table ($fields) VALUES ($placeholders)";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
            return $this->db->execute() ? true : false;
        } else {
            return false;
        }
    }


    final public function atualizar($data, $id, $idColumn = 'id') {
        if (!empty($data) && is_array($data)) {
            $setParts = [];
            foreach ($data as $key => $value) {
                $setParts[] = "$key = :$key";
            }
            $setClause = implode(', ', $setParts);
            $query = "UPDATE $this->table SET $setClause WHERE $idColumn = :id";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
            $this->db->bind(':id', $id);
            return $this->db->execute() ? true : false;
        } else {
            return false;
        }
    }

    final public function deletar($id, $idColumn = 'id') {
        $query = "DELETE FROM $this->table WHERE $idColumn = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute() ? true : false;
    }

    final public function mostrar($id, $idColumn = 'id') {
        $query = "SELECT * FROM $this->table WHERE $idColumn = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    final public function query($rawQuery) {
        $this->db->query($rawQuery);
        return $this->db->resultSet();
    }

    final public function all() {
        $query = "SELECT * FROM $this->table";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    final public function first() {
        $query = (!$this->db instanceof OracleConnection) ? $this->getFirstDefault() : $this->getFirstOracle();
        $this->db->query($query);
        return $this->db->single();
    }

    public function last() {
        $query = "SELECT * FROM $this->table ORDER BY 1 DESC LIMIT 1;";
        $this->db->query($query);
        return $this->db->single();
    }

    protected function getFirstDefault() {
        return "SELECT * FROM $this->table LIMIT 1;";
    }

    protected function getFirstOracle() {
        return "SELECT * FROM (SELECT * FROM $this->table) WHERE ROWNUM = 5";
    }

    protected function contarRegistrosDaQuery($query)
    {
        $countQuery = "SELECT COUNT(*) as total FROM ($query) as __subquery";
        $this->db->query($countQuery);
        return $this->db->single()['total'];
    }

    public function paginarQuery($query, $itemsPerPage = 10)
    {

        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $page = max($page, 1);

        $start = ($page - 1) * $itemsPerPage;
        $totalRows = $this->contarRegistrosDaQuery($query);

        $query .= " LIMIT :itemsPerPage OFFSET :start";
        $this->db->query($query);
        $this->db->bind(':start', $start, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        $data = $this->db->resultSet();

        $totalPages = ceil($totalRows / $itemsPerPage);

        $this->paginacao = ['__totalPaginas' => $totalPages, '__paginaAtual' => $page];

        return $data;
    }


    final public function contarTodos() {
        $this->db->query("SELECT COUNT(*) as count FROM $this->table");
        return $this->db->single()['count'];
    }


    public function paginarTodos($itemsPerPage = 10)
    {
        $query = "SELECT * FROM $this->table";

        $totalRows = $this->contarRegistrosDaQuery($query);

        $query .= " LIMIT :itemsPerPage OFFSET :start";

        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $page = max($page, 1);

        $totalPages = ceil($totalRows / $itemsPerPage);

        $this->paginacao = ['__totalPaginas' => $totalPages, '__paginaAtual' => $page];

        $this->db->query($query);
        $this->db->bind(':start', ($page - 1) * $itemsPerPage, \PDO::PARAM_INT);
        $this->db->bind(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function getPaginacao()
    {
        return $this->paginacao;
    }

    public static function composicoes_2022()
    {
        return '231,232,233,234,240';
    }
    public static function composicoes_2023()
    {
        return '241,242,243,244,245';
    }
    public static function composicoes_2024()
    {
        return '249,259,258,250,262,283,272';
    }

    public function getComposicoes($ano_letivo) {
        $sql = "
				select distinct on (ape.composicao_ensino.comp_ensino)
				ape.composicao_ensino.comp_ensino,
				ape.composicao_ensino.curso,
				ape.composicao_ensino.nivel,
				ave.ave_matricula.ano_letivo
			from
				ape.composicao_ensino
			join ape.ape_serie
				on (ape.composicao_ensino.curso = ape.ape_serie.codigo_ape_composicao_ensino)
			join ave.ave_matricula
				on (ave.ave_matricula.codigo_ape_serie 	  = ape.ape_serie.codigo
					and ave.ave_matricula.situacao_oferta = 1)
			where true ";

        if($ano_letivo <= 2022){
            $sql .= " and ape.composicao_ensino.curso in (".self::composicoes_2022().") ";
        }else
            if($ano_letivo == 2023){
                $sql .= " and ape.composicao_ensino.curso in (".self::composicoes_2023().") ";
            }else
                if($ano_letivo >= 2024){
                    $sql .= " and ape.composicao_ensino.curso in (".self::composicoes_2024().") ";
                }

        $this->db->query($sql);
        return $this->db->resultSet();
    }
}
?>
