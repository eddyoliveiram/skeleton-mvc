<?php

namespace App\Core\Basic;

class Redirector {
    private $url;

    public function __construct($url = '') {
        $this->url = $url;
    }

    public function success($message) {
        $_SESSION['__SUCCESS'] = ucfirst($message);
        return $this;
    }

    public function error($message) {
        if (!isset($_SESSION['__ERRORS'])) {
            $_SESSION['__ERRORS'] = [];
        }
        if (is_array($message)) {
            foreach ($message as $msg) {
                $_SESSION['__ERRORS'][] = ucfirst($msg);
            }
        } else {
            $_SESSION['__ERRORS'][] = ucfirst($message);
        }
        return $this;
    }


    public function __destruct() {
        if (!empty($this->url)) {
            header('Location: ' . PUBLIC_PATH . '/' . $this->url);
            exit();
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
