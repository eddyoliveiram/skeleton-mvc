<?php
namespace Core;

class Controller {
    public function model($model) {
        require_once  __DIR__ . '/../models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data) {
        extract($data);
        $old = isset($old) ? $old : null;
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
?>
