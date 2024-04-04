<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Repositories\UsuarioRepositorio;
use App\Core\Controller;
use App\Validators\UsuarioValidacao;
use App\Services\PaginationService;

class IndexController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UsuarioRepositorio();
    }

    public function index()
    {
        $paginationService = new PaginationService(new UsuarioRepositorio());
        $paginationService->paginate('users',5);
        $this->view('index');
    }

    public function store()
    {
        $user = new UsuarioModel();
        $validator = new UsuarioValidacao($_REQUEST);

        if ($validator->validate()){
            $user->insert($validator->getValidated());
            $validator->addSuccessMessage('Usuário criado com sucesso.');
        }

        $this->redirect('index', 'index');
    }

}
?>
