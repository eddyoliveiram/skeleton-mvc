<?php
namespace Core;

class Controller {
    public function model($model) {
        require_once  __DIR__.'/../models/'. $model . '.php';

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
        require_once __DIR__.'/../views/'. $view . '.php';
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

    public function example()
    {
        $users = [
            ['id' => 1, 'name' => 'Eddy'],
            ['id' => 2, 'name' => 'Lucas'],
        ];

        $posts = [
            ['userId' => 1, 'id' => '1', 'desc' => 'Post do usuário 1'],
            ['userId' => 2, 'id' => '2', 'desc' => 'Post do usuário 2'],
            ['userId' => 1, 'id' => '3', 'desc' => 'Outro post do usuário 1'],
        ];

        $coments = [
            ['postId' => 1, 'id' => '1', 'comment' => 'P1'],
            ['postId' => 1, 'id' => '4', 'comment' => 'P1'],
            ['postId' => 1, 'id' => '5', 'comment' => 'P1'],
            ['postId' => 2, 'id' => '2', 'comment' => 'P2'],
            ['postId' => 1, 'id' => '3', 'comment' => 'P1'],
        ];

        $postsWithComments = $this->nest($posts, $coments, 'id', 'postId', 'coments');
        $usersWithPostsAndComments = $this->nest($users, $postsWithComments, 'id', 'userId', 'posts');

        echo '<pre>';
        print_r($usersWithPostsAndComments);
        echo '</pre>';
    }

}
?>
