<?php

namespace Advvm\Middlewares\Validations\Report;

use CoffeeCode\Router\Router;
use Advvm\Library\Validations\Report\ReportFindValidation;
use Respect\Validation\Exceptions\NestedValidationException;

class ReportFindValidationMiddleware
{
    public function handle(Router $router)
    {
        try {
            ReportFindValidation::getValidator()->assert($router->data());
        } catch (NestedValidationException $e) {
            http_response_code(400);
            echo json_encode(['errors' => $e->getMessages()]);

            return;
        }

        return $router->current();
    }
}
