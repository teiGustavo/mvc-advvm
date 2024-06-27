<?php

namespace Advvm\Middlewares\Validations\Report;

use CoffeeCode\Router\Router;
use Advvm\Library\Validations\Report\ReportUpdateValidation;
use Respect\Validation\Exceptions\NestedValidationException;

class ReportUpdateValidationMiddleware
{
    public function handle(Router $router)
    {
        try {
            ReportUpdateValidation::getValidator()->assert($router->data());
        } catch (NestedValidationException $e) {
            http_response_code(400);
            echo json_encode(['errors' => $e->getMessages()]);

            return;
        }

        return $router->current();
    }
}
