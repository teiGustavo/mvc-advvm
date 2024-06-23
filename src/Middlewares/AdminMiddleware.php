<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;

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

        $jwt = $_SESSION["token"];

        //Recupera o token salvo no cookie ou sessão
        if (empty($jwt)) {
            return false;
        }

        //Converte o token em array (String para Array)
        [, $payload] = explode(".", $jwt);

        $isAdm = (json_decode(base64_decode($payload)))->adm;

        return $isAdm;
    }
}
