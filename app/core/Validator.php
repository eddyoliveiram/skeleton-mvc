<?php
namespace Core;

class Validator {
    protected $data = [];
    protected $validated = [];

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
        return $isValid;
    }

    public function getValidated() {
        return $this->validated;
    }

    protected function required($attribute) {
        if (empty($this->data[$attribute])) {
            $this->addErrorMessage("{$attribute} é obrigatório.");
            return false;
        }
        return true;
    }

    protected function email($attribute) {
        if (!filter_var($this->data[$attribute], FILTER_VALIDATE_EMAIL)) {
            $this->addErrorMessage("{$attribute} precisa ser um email válido.");
            return false;
        }
        return true;
    }

    public function addErrorMessage($message) {
        if (!isset($_SESSION['__ERRORS'])) {
            $_SESSION['__ERRORS'] = [];
        }
        $_SESSION['__ERRORS'][] = ucfirst($message);
    }

    public function addSuccessMessage($message) {
        $_SESSION['__SUCCESS'] = $message;
    }

    protected function rules() {
        return [];
    }
}

?>
