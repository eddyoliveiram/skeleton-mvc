<?php
namespace App\Repositories;
use App\Contracts\DataRepositoryInterface;
use App\Core\Basic\Model;

class UsuarioRepositorio implements DataRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll($page = 1, $itemsPerPage = 15)
    {
        return $this->model->allPaginated($page, $itemsPerPage);
    }

    public function getTotal()
    {
        return $this->model->getTotal();
    }

    public function create(array $userData)
    {
        return $this->model->insert($userData);
    }

}


