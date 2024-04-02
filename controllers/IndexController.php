
<?php 
require_once '../core/Controller.php';

class IndexController extends Controller {
    public function index() {
        //$user = $this->model('UserModel');
        //$data = $user->getUser();
        echo "Método index foi chamado!<br>";

        $this->view('index', ['name' => 'eddy']);
    }
    public function store() {
        echo "Método store foi chamado!<br>";
        echo '<pre>'; print_r($_REQUEST); exit;
    }
    public function teste() {
        echo "Método teste foi chamado!<br>";
        echo '<pre>'; print_r($_REQUEST); exit;
    }
}
?>
