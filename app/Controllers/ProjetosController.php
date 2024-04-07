<?php
namespace App\Controllers;
use App\Core\Basic\Controller;
use App\Core\Basic\Redirector;
use App\Models\ProjetoModel;
use App\Models\UsuarioModel;
use App\Services\PaginationService;
use App\Validators\ProjetosValidacao;
use App\Validators\UsuarioValidacao;

class ProjetosController extends Controller
{
    public function __construct(){
    }

    public function index()
    {
        $projeto = new ProjetoModel();
        $query_crua = "SELECT * FROM USERS WHERE SEXO LIKE 'F' AND IDADE >= 18";
//        $users2 = $projeto->paginarQuery($query_crua,10);

        $users = $projeto->paginarTodos(10);
        $paginacao = $projeto->getPaginacao();

        return view('banco-de-projetos/index',
            ['paginacao' => $paginacao, 'users' =>  $users ]
        );
    }

    public function store()
    {
        $user = new UsuarioModel();
        $validator = new ProjetosValidacao($_REQUEST);

        if (!$validator->validate()){
            return redirect('projetos/index')->error($validator->getErrors());
        }

        $user->insert($validator->getValidated());
        return redirect('projetos/index')->success('Usuário criado com sucesso.');
    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function delete()
    {
        $user = new UsuarioModel();
        $user->delete($_POST['id'], 'cd_inscricao');

        return redirect('projetos/index')->success('Usuário deletado com sucesso.');
    }

    public function deletar()
    {
        $user = new UsuarioModel();
        $user->delete($_POST['id'], 'cd_inscricao');

        return redirect('projetos/index')->success('Usuário deletado com sucesso.');
    }

}
?>
