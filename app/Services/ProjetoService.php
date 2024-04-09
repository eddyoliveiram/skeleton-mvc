<?php

namespace App\Services;

use App\Models\ProjetoModel;

class ProjetoService
{
    public function algumaValidacaoEspecifica()
    {
        $projetoModel = new ProjetoModel();
        $result = $projetoModel->algumaQueryEspecifica();
        return $result;
    }
}