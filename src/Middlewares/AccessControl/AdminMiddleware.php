<?php

namespace Advvm\Middlewares\AccessControl;

use CoffeeCode\Router\Router;
use Advvm\Library\JsonWebToken;
use Advvm\Library\Roles;
use Advvm\Library\Session;

class AdminMiddleware
{
    public function handle(Router $router)
    {
        if ($this->isAdmin() === true) {
            return $router->current();
        }

        return $router->redirect($router->route('error', ['errcode' => 401]));
    }

    private function isAdmin(): bool
    {
        if (NEEDS_AUTH !== 'true' || !Session::has('token')) {
            return false;
        }

        $data = JsonWebToken::decode(Session::get('token'));

        if (!empty($data) && $data['role'] === Roles::ADMINISTRATOR) {
            return true;
        }

        return false;
    }
}
