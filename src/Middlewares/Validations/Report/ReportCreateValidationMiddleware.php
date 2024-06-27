<?php

namespace Advvm\Middlewares\Validations\Report;

use CoffeeCode\Router\Router;
use Advvm\Library\Validations\Report\ReportCreateValidation;
use Respect\Validation\Exceptions\NestedValidationException;

class ReportCreateValidationMiddleware
{
    public function handle(Router $router)
    {
        try {
            ReportCreateValidation::getValidator()->assert($router->data());
        } catch (NestedValidationException $e) {
            http_response_code(400);
            echo json_encode(['errors' => $e->getMessages()]);

            return;
        }

        return $router->current();
    }
}
