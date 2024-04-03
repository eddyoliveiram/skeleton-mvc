<?php

namespace Validators;

class Validator extends BaseValidator
{
    protected $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $this->applyRule($field, $singleRule, isset($data[$field]) ? $data[$field] : null);
            }
        }

        return empty($_SESSION[$this->errorsKey]);
    }

    protected function applyRule($field, $rule, $value)
    {
        $parameters = [];
        if (strpos($rule, ':') !== false) {
            list($rule, $parameter) = explode(':', $rule, 2);
            $parameters = explode(',', $parameter);
        }

        if ($rule === 'required') {
            if ($value === null || $value === '') {
                $this->addError($field, "O campo {$field} é obrigatório.");
            }
        } elseif ($rule === 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, "O campo {$field} deve ser um endereço de e-mail válido.");
            }
        }

    }
}
?>
