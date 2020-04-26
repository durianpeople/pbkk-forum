<?php

namespace Module\Forum\Presentation\Web\Validator;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\StringLength\Min;

class RegistrationValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            'username',
            new Alnum([
                'message' => 'Username must be alphanumeric'
            ])
        );

        $this->add(
            'password',
            new Min([
                "min" => 8,
                'message' => 'Password should be at least 8 characters',
            ])
        );
    }
}
