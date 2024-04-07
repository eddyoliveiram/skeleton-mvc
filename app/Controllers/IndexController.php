<?php
namespace App\Controllers;
use App\Core\Basic\Controller;
use App\Models\ProfessorModel;
use App\Models\UsuarioModel;
use App\Repositories\UsuarioRepositorio;
use App\Services\PaginationService;
use App\Validators\UsuarioValidacao;

class IndexController extends Controller
{
    protected $userRepository;
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->professorModel = new ProfessorModel();
        $this->userRepository = new UsuarioRepositorio($this->usuarioModel);
    }

    public function index()
    {
//        echo '<pre>';print_r($this->usuarioModel->countAll());die();

//        $paginationService = new PaginationService($this->usuarioModel);
//        $paginationService->paginate('users', 5);
        return view('index');
    }

    public function store()
    {
        $user = new UsuarioModel();
        $validator = new UsuarioValidacao($_REQUEST);

        if ($validator->validate()){
            $user->inserir($validator->getValidated());
        }
    }

}
?>
