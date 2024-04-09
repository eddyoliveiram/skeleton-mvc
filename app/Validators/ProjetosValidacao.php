<?php
namespace App\Validators;
use App\Core\Utilities\Validator;

class ProjetosValidacao extends Validator {

    protected function rules() {
        return [
            'nome' => ['obrigatorio'],
            'dt_nascimento' => ['obrigatorio','data','regra2024customizavel']
        ];
    }

    protected function regra2024customizavel($attribute) {

        if (isset($this->data[$attribute])) {
             $date = $this->data[$attribute];
             $year = date("Y", strtotime($date));
            if ($year != 2024) {
                $this->addError("O ano deve ser igual a 2024.");
                return false;
            }
        }
        return true;
    }
}
?>
