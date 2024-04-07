<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__.'/../../vendor/autoload.php';

$conexao = new Conexao(); //composer.json
$_SESSION['__BANCO_INTRANET'] = $conexao->banco;

use App\core\App;
//echo '<pre>';print_r($_SESSION);die();

$app = new App();

?>
