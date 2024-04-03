<?php
namespace Controllers;
use Models\ProfessorModel;
use Models\UserModel;
use Core\Controller;
use Validators\Validator;

class IndexController extends Controller
{

    public function index()
    {
        $userModel = new UserModel();

        $users = $userModel->All();

        $this->view('index', [
            'users' => $users
        ]);
    }

    public function id()
    {
//        $professorModel = new ProfessorModel();
//        $validator = new Validator();
//
//        $data = [
//            'id' => $_REQUEST['id']
//        ];
//
//        $rules = [
//            'id' => 'required'
//        ];
//
//        if (!$validator->validate($data, $rules)) {
//            echo "Errors found:<br>";
//            $errors = $validator->getErrors();
//            foreach ($errors as $field => $fieldErrors) {
//                foreach ($fieldErrors as $error) {
//                    echo "- {$error}<br>";
//                }
//            }
//        }
//
//        $professors = $professorModel->getUserById($_REQUEST['id']);
//
//        $this->view('index', [
//            'professors' => $professors
//        ]);
    }

    public function store()
    {
        $userModel = new UserModel();
        $validator = new Validator();

        $nome = isset($_REQUEST['nome']) ? $_REQUEST['nome'] : null;
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;

        $data = [
            'name' => $nome,
            'email' => $email,
            'remember_token' => 12313,
            'password' => md5(12313),
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'remember_token' => 'required',
            'password' => 'required'
        ];


        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
        }else{
            $success = 'User created with success';
            $userModel->insert($data);
        }

        $users = $userModel->all();

        $this->view('index', [
            'users' => isset($users) ? $users : null,
            'errors' => isset($errors) ? $errors : null,
            'success' => isset($success) ? $success : null,
            'old' => $_REQUEST
        ]);
    }

}
?>
