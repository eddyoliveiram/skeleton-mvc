<?php
namespace App\Repositories;
use App\Contracts\DataRepositoryInterface;
use App\Core\Basic\Model;

class ProjetosRepositorio implements DataRepositoryInterface
{
    public function algumaQueryEspecifica()
    {
        return true;
    }
}


