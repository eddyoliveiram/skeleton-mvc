<?php
namespace Controllers;
use Core\Controller;
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
        $validator = new UserValidator($_REQUEST);
        $userRepository = new UserRepository();

        if ($validator->validated) {
            $userRepository->createUser($validator->validated);
            $validator->setMessage('User created with success.');
        }

        $this->redirect('/index/index');
    }

}
?>
