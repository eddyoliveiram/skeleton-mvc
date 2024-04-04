<?php
namespace Core;

class Controller {
    public function model($model) {
        require_once  __DIR__ . '/../models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data = null) {
        if($data != ''){
            extract($data);
        }
        if(!isset($_SESSION['__OLD'])){
            $_SESSION['__OLD'] = null;
        }
//        $old = isset($old) ? $old : null;
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function redirect($controller, $method) {
//        echo '<pre>';print_r(BASE_PATH);die();
        header('Location: ' . BASE_PATH.'/'.$controller.'/'.$method);
        exit;
    }

    public function nest($primaryArray, $secondaryArray, $primaryKey, $foreignKey, $attachKey) {
        $itemsByForeignKey = [];
        foreach ($secondaryArray as $item) {
            $itemsByForeignKey[$item[$foreignKey]][] = $item;
        }

        foreach ($primaryArray as &$primaryItem) {
            $keyValue = $primaryItem[$primaryKey];
            $primaryItem[$attachKey] = isset($itemsByForeignKey[$keyValue]) ? $itemsByForeignKey[$keyValue] : [];
        }
        unset($primaryItem);

        return $primaryArray;
    }

}
?>
