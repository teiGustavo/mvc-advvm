<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;

class AuthMiddleware
{
    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router): bool
    {
        $user = false;

        if ($user) {
            var_dump($router->current());
            return true;
        } else {
            
        }
        
        return false;
    }
}