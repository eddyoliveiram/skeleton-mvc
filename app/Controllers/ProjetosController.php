<?php
namespace App\Controllers;
use App\Core\Basic\Controller;
use App\Models\ProjetoModel;

class ProjetosController extends Controller
{
    public function __construct(){
    }

    public function index()
    {
        $projeto = new ProjetoModel();
        $projetos = $projeto->all();
//        return redirect('projetos/store');
        return view('banco-de-projetos/index', $projetos);
    }

    public function store()
    {
        echo 'aqui';
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
