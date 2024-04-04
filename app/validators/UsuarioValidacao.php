<?php
namespace App\Validators;

use App\core\Validator;

class UsuarioValidacao extends Validator {

    protected function rules() {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    protected function customValidation($attribute) {
        if ($this->data[$attribute] != '') {
            $this->addErrorMessage($attribute, "I am a custom rule.");
        }
    }
}

?>
