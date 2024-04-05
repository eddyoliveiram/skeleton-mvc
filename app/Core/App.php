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
                $msg = "App\Controllers\<b style='color: #e67300;'>null</b><BR><BR>"
                    ."O <b style='color: #e67300;'>controller</b> está vazio na url.";
            }else{
                $msg = "O controller <b style='color: #e67300;'>{$controllerName}</b> não foi encontrado.";
            }
            $this->loadError($msg);
        }

        $controllerClassName = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClassName();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }else {
            $msg = $controllerClassName."\<b style='color: #e67300;'>null</b><BR><BR>"
            ."O <b style='color: #e67300;'>método</b> está vazio na url.";
            $this->loadError($msg);
        }

        if($this->method == ''){
            $msg = "O método <b style='color: #e67300;'>{$url[1]}()</b> não foi encontrado em  <b style='color: #e67300;'>{$controllerName}</b>.";
            $this->loadError($msg);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function setGlobals() {
        $public_path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $pathParts = explode('/', $_SERVER['PHP_SELF'], -1);
        $rootFolder = $pathParts[1];
        $view_path = __DIR__.'/../Views';
        $core_path = __DIR__.'/../Core';

        define('ROOT_FOLDER', $rootFolder);
        define('PUBLIC_PATH', $public_path);
        define('CORE_PATH', $core_path);
        define('VIEW_PATH', $view_path);
//        echo '<pre>';print_r($basePath. ' x '.$rootFolder.' x '.$viewPath);die();
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
//        require_once '../views/errors/error_url.php';
        include CORE_PATH.'/Notifications/Errors/error_not_found.php';
        die();
    }

    private function ExceptionHandler($boolean)
    {
        if($boolean) {

            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                if ($errno === E_NOTICE && strpos($errstr, 'Array to string conversion') !== false) {
                    $showDetails = true;
                    $errorMessage = $errstr;
                    $errorFile = $errfile;
                    $errorLine = $errline;
                    include CORE_PATH.'/Notifications/Errors/error_notice.php';
                }
            });

            set_exception_handler(function ($exception) {
                $isDevEnv = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);
                $errorMessage = $exception->getMessage();
                $errorFile = $exception->getFile();
                $errorLine = $exception->getLine();
                $showDetails = $isDevEnv;
                include CORE_PATH.'/Notifications/Errors/error_exception.php';
                exit;
            });

        }
    }

}

?>
