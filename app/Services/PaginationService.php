<?php
namespace App\Services;

use App\Core\Basic\Model;

class PaginationService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function paginar($itemsPerPage = 9)
    {
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $page = max($page, 1);

        $data = $this->model->paginateAll($page, $itemsPerPage);
        $totalUsers = $this->model->countAll();
        $totalPages = ceil($totalUsers / $itemsPerPage);

        return [
            '__registrosPaginados' => $data,
            '__totalPaginas' => $totalPages,
            '__paginaAtual' => $page,
        ];
    }
}