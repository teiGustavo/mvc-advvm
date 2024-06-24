<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;
use Advvm\Library\JsonWebToken;

class AdminMiddleware
{

    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router)
    {
        if ($this->isAdmin() === true) {
            return $router->current();
        }

        return $router->redirect($router->route('error', ['errcode' => 401]));
    }

    private function isAdmin(): bool
    {
        if (NEEDS_AUTH !== 'true') {
            return false;
        }

        initializeSessions();

        //Recupera o token salvo no cookie ou sessão
        if (!isset($_SESSION["token"]) || $_SESSION["token"] == "") {
            return false;
        }

        $data = JsonWebToken::decode($_SESSION["token"]);

        if (!empty($data) && $data['role'] === ROLE_ADMINISTRATOR) {
            return true;
        }

        return false;
    }
}
