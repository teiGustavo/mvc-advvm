<?php

namespace Advvm\Library\Validations\Report;

use Respect\Validation\Validator;
use Respect\Validation\Rules\Key;
use Respect\Validation\Rules\AllOf;

class ReportCreateValidation
{
    public static function getValidator(): Validator
    {
        $validate = new Validator();

        $validate->addRule(
            new Key('date', new AllOf(
                Validator::notEmpty()->setTemplate('Este campo é obrigatório'),
                Validator::date()->setTemplate('Precisa estar no formato aaaa-mm-dd')
            ))
        );

        $validate->addRule(
            new Key('report', new AllOf(
                Validator::notEmpty()->setTemplate('Este campo é obrigatório'),
                Validator::length(3, null)->setTemplate('Precisa ter no mínimo 3 caracteres')
            ))
        );

        $validate->addRule(
            new Key('amount', new AllOf(
                Validator::notEmpty()->setTemplate('Este campo é obrigatório'),
                // Validator::regex('^[0-9.,]+$^')->setTemplate('Precisa ser um número válido'),
            ))
        );

        $validate->addRule(
            new Key('type', Validator::notEmpty()->setTemplate('Este campo é obrigatório'))
        );

        return $validate;
    }
}
