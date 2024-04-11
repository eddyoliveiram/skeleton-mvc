<?php

namespace App\Services;

use App\Repositories\ProjetosRepositorio;

class ProjetoService
{
    public function algumaValidacaoEspecifica()
    {
        $projetoRepositorio = new ProjetosRepositorio();
        $result = $projetoRepositorio->algumaQueryEspecifica();
        return $result;
    }
}