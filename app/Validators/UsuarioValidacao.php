<?php
namespace App\Validators;

use App\Core\Utilities\Validator;

class UsuarioValidacao extends Validator {

    protected function rules() {
        return [
            'nome' => ['required'],
            'cpf' => ['numeric']
        ];
    }

    protected function customValidation($attribute) {
        if ($this->data[$attribute] != '') {
            $this->addErrorMessage($attribute, "I am a custom rule.");
        }
    }
}

?>
