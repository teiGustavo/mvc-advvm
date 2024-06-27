<?php

namespace Advvm\Library\Validations\Report;

use Respect\Validation\Validator;
use Respect\Validation\Rules\Key;
use Respect\Validation\Rules\AllOf;

class ReportDeleteValidation
{
    public static function getValidator(): Validator
    {
        $validate = new Validator();

        $validate->addRule(
            new Key('id', new AllOf(
                Validator::notEmpty()->setTemplate('Este campo é obrigatório'),
                Validator::intVal()->setTemplate('Precisa ser um número inteiro'),
                Validator::positive()->setTemplate('Precisa ser positivo'),
            ))
        );

        return $validate;
    }
}
