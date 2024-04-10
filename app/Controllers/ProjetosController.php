<?php
namespace App\Controllers;
use App\Core\Basic\Controller;
use App\Models\ProjetoModel;
use App\Models\UsuarioModel;
use App\Services\ProjetoService;
use App\Validators\ProjetosValidacao;

class ProjetosController extends Controller
{
    public function __construct(){
    }

    public function index()
    {
        $projeto = new ProjetoModel();
        $query_crua = "SELECT * FROM projetos.fee_inscritos order by cd_inscricao DESC";
        $users2 = $projeto->paginarQuery($query_crua,10);

        $users = $projeto->paginarTodos(10);
        $paginacao = $projeto->getPaginacao();

        return view('banco-de-projetos/index',
            ['paginacao' => $paginacao, 'users' =>  $users2]
        );
    }

    public function inserir()
    {
        $user = new UsuarioModel();
        $projetoService = new ProjetoService();
        $validator = new ProjetosValidacao($_REQUEST);

        if (!$validator->validarInputs()){
            return redirect('projetos/index')->error($validator->getErrors());
        }

        $boolean = $projetoService->algumaValidacaoEspecifica();

        if(!$boolean){
            return redirect('projetos/index')->error('Não irá executar pois está true.');
        }

        $user->inserir($validator->getValidated());
        return redirect('projetos/index')->success('Usuário criado com sucesso.');
    }

    public function mostrar()
    {

    }

    public function atualizar()
    {
        $user = new UsuarioModel();
        $validator = new ProjetosValidacao($_REQUEST);
        $id = $_REQUEST['cd_inscricao'];

        if (!$validator->validarInputs()){
            return redirect('projetos/index')->error($validator->getErrors());
        }

        $result = $user->atualizar($validator->getValidated(),$id,'cd_inscricao');

        if(!$result){
            return redirect('projetos/index')->error('Não foi possível concluir esta ação.');
        }

        return redirect('projetos/index')->success('Usuário atualizado com sucesso.');
    }

    public function deletar()
    {
        $user = new UsuarioModel();
        $result = $user->deletar($_POST['id'], 'cd_inscricao');

        if(!$result){
            return redirect('projetos/index')->error('Não foi possível concluir esta ação.');
        }

        return redirect('projetos/index')->success('Usuário deletado com sucesso.');
    }

}
?>
