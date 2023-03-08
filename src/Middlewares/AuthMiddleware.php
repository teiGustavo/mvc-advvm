<?php

namespace Source\Middlewares;

use CoffeeCode\Router\Router;

class AuthMiddleware
{
    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router): bool
    {
        $user = true;
        if ($user) {
            var_dump($router->current());
            return true;
        }
        return false;
    }
}