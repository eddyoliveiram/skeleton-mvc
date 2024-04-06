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
//        dd($projeto->somente15());
        $users = $projeto->paginarTodos(10);
        $paginacao = $projeto->getPaginacao();

        return view('banco-de-projetos/index',
            ['paginacao' => $paginacao, 'users' =>  $users ]
        );
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
