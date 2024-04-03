<?php
namespace Controllers;

use Core\Controller;

class AboutController extends Controller {
    public function index() {
        $this->view('about', ['name' => 'eddy']);
    }
    public function services() {
        $this->view('services', ['name' => 'eddy']);
    }
    public function teste() {
        echo "Método TESTE de ABOUT foi chamado!<br>";
        echo '<pre>'; print_r($_REQUEST); exit;
        $this->view('about', ['name' => 'eddy']);
    }
}
?>
