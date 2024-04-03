<?php

namespace Core;

class BaseValidator
{
    protected $errorsKey = 'validation_errors';

    public function addError($field, $message)
    {
        $errors = isset($_SESSION[$this->errorsKey]) ? $_SESSION[$this->errorsKey] : [];

        $errors[$field][] = $message;

        $_SESSION[$this->errorsKey] = $errors;
    }

    public function getErrors()
    {
        if (isset($_SESSION[$this->errorsKey]) && is_array($_SESSION[$this->errorsKey])) {
            $errors = $_SESSION[$this->errorsKey];
            unset($_SESSION[$this->errorsKey]);
            return $errors;
        }
        return [];
    }
}
?>
