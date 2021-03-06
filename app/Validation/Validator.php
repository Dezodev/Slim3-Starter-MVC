<?php

namespace App\Validation;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator 
{
    protected $errors;

    public function Validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucFirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();             
            }
        }

        $_SESSION['validatorError'] = $this->errors;

        return $this;
    }

    public function failed()
    {   
        return !empty($this->errors);
    }
}
