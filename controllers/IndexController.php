<?php
namespace Controllers;
use Core\Controller;
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
        $userModel = new UserModel();
        $paginationService = new PaginationService();
        $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $paginated = $paginationService->paginate('users',$page, 5);
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
