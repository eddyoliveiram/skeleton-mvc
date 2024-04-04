<?php
namespace App\Core;

class App {
    private static $instance;
    protected $controller = '';
    protected $method = '';
    protected $params = [];

    public function __construct() {

        $this->ExceptionHandler(TRUE);

        $this->setGlobals();

        $url = $this->parseUrl();

        $controllerName = ucfirst($url[0]) . 'Controller';

        if (file_exists('../controllers/' . $controllerName . '.php')) {
            $this->controller = $controllerName;
            unset($url[0]);
        }else {
            if($url[0] == ''){
                $msg = "No <b style='color: #e67300;'>{ Controller }</b> was provided in the url.";
            }else{
                $msg = "<b style='color: #e67300;'>{$controllerName}</b> was not found";
            }
            $this->loadError($msg);
        }

        $controllerClassName = '\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClassName();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }else {
            $msg = "No<b style='color: #e67300;'> { Method }</b> was not provided in the url.";
            $this->loadError($msg);
        }

        if($this->method == ''){
            $msg = "The method <b style='color: #e67300;'>{$url[1]}()</b> was not found in  <b style='color: #e67300;'>{$controllerName}</b>.";
            $this->loadError($msg);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function setGlobals() {
        $basePath = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $pathParts = explode('/', $_SERVER['PHP_SELF'], -1);
        $rootFolder = $pathParts[1];
        $viewPath = __DIR__.'/../views/';

        define('BASE_PATH', $basePath);
        define('ROOT_PATH', $rootFolder);
        define('VIEW_PATH', $viewPath);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function parseUrl() {
        if (isset($_GET['__url'])) {
            return explode('/', filter_var(rtrim($_GET['__url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    private function loadError($message) {
        require_once '../views/errors/error_url.php';
        die();
    }

    private function ExceptionHandler($boolean)
    {
        if($boolean) {
            set_exception_handler(function ($exception) {
                $isDevEnv = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

                $errorMessage = $exception->getMessage();
                $errorFile = $exception->getFile();
                $errorLine = $exception->getLine();
                $showDetails = $isDevEnv;
                include VIEW_PATH.'/errors/error_exception.php';
                exit;
            });
        }
    }

}

?>
