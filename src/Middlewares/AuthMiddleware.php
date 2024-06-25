<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;
use Advvm\Library\JsonWebToken;
use Advvm\Library\Session;

class AuthMiddleware
{
    public function handle(Router $router)
    {
        if (NEEDS_AUTH !== 'true') {
            return $router->current();
        }

        if ($this->isAuth() === false) {
            return $router->redirect("auth.login");
        }

        return $router->current();
    }

    private function isAuth(): bool
    {
        if (!Session::has('token')) {
            return false;
        }

        if (JsonWebToken::isValid(Session::get('token'))) {
            return true;
        }

        return false;
    }
}
