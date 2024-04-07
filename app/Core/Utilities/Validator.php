<?php
namespace App\Core\Utilities;

class Validator {
    protected $data = [];
    protected $validated = [];
    protected $errors = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function validate() {
        $isValid = true;
        foreach ($this->rules() as $attribute => $rules) {
            foreach ($rules as $rule) {
                if (!$this->$rule($attribute)) {
                    $isValid = false;
                } else {
                    $this->validated[$attribute] = $this->data[$attribute];
                }
            }
        }
        if(!$isValid){
            $_SESSION['__OLD'] = $this->data;
        }
        return $isValid;
    }

    public function getValidated() {
        return $this->validated;
    }

    protected function obrigatorio($attribute) {
        if (empty($this->data[$attribute])) {
            $this->addError("{$attribute} é obrigatório.");
            return false;
        }
        return true;
    }

    protected function email($attribute) {
        if (!filter_var($this->data[$attribute], FILTER_VALIDATE_EMAIL)) {
            $this->addError("{$attribute} precisa ser um email válido.");
            return false;
        }
        return true;
    }

    protected function opcional($attribute) {
        return true;
    }

    protected function numerico($attribute) {
        if (isset($this->data[$attribute]) && !is_numeric($this->data[$attribute])) {
            $this->addError("{$attribute} precisa ser numérico.");
            return false;
        }
        return true;
    }

    protected function data($attribute) {
        if (isset($this->data[$attribute])) {
            $date = $this->data[$attribute];
            if (!strtotime($date)) {
                $this->addError("{$attribute} precisa ser uma data válida.");
                return false;
            }
        }
        return true;
    }

    protected function arquivo($attribute) {
        if (isset($this->data[$attribute]) && !is_file($this->data[$attribute])) {
            $this->addError("{$attribute} precisa ser um arquivo.");
            return false;
        }
        return true;
    }


    public function addError($message) {
        $this->errors[] = $message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function success($message) {
        $_SESSION['__SUCCESS'] = $message;
    }

    protected function rules() {
        return [];
    }
}

?>
