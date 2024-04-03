<?php
namespace Controllers;
use Core\Controller;
use Models\ProfessorModel;
use Models\UserModel;
use Repositories\UserRepository;
use Validators\UserValidator;
use Services\PaginationService;

class IndexController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        $paginationService = new PaginationService(new UserRepository());
        $paginationService->paginate('users', 5);
        $this->view('index');
    }

    public function store()
    {
        $user = new UserModel();
        $validator = new UserValidator($_REQUEST);

        if ($validator->validated) {
            $user->insert($validator->validated);
            $validator->setMessage('User created with success.');
        }

        $this->redirect('index', 'index');
    }

}
?>
