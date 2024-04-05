<?php
/**
 * Renderiza uma view com os dados fornecidos.
 *
 * Esta função inclui o arquivo da view especificado e extrai os dados fornecidos
 * para torná-los disponíveis no escopo da view. Após a inclusão do arquivo da view,
 * ela retorna o conteúdo do buffer de saída como uma string.
 *
 * @param string $view O nome do arquivo da view a ser renderizado.
 * @param array $data (Opcional) Os dados a serem passados para a view.
 */
if (!function_exists('view')) {
    function view($view, $dados = []) {
        if(!empty($dados)){
            extract($dados);
        }
        if(!isset($_SESSION['__OLD'])){
            $_SESSION['__OLD'] = null;
        }
        $viewPath = VIEW_PATH . '/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
            return true;
        } else {
            $showDetails = true;
            $message = "A view <b style='color: #e67300;'>$view.php</b> não foi encontrada.";
            require_once CORE_PATH.'/Notifications/Errors/error_not_found.php';
            return false;
        }
    }
}
if (!function_exists('redirect')) {
    function redirect($url = '') {
        if (!empty($url)) {
            header('Location: ' . PUBLIC_PATH . '/' . $url);
            return false;
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return true;
        }
    }
}
