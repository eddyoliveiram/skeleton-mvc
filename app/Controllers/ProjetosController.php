<?php
namespace App\Controllers;
use App\Core\Basic\Controller;
use App\Models\ProjetoModel;
use App\Services\PaginationService;

class ProjetosController extends Controller
{
    public function __construct(){
    }

    public function index()
    {
        $projeto = new ProjetoModel();
        $service = new PaginationService($projeto);
        $result = $service->paginate(10);
        return view('banco-de-projetos/index', $result);
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}
?>
