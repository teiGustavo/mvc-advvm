<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;
use Advvm\Library\JsonWebToken;
use Advvm\Library\Session;

class AuthMiddleware
{
    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router)
    {
        if (NEEDS_AUTH !== 'true') {
            return $router->current();
        }

        //Verifica se a autenticação está habilitada e se o usuário não está autenticado
        if ($this->isAuth() === false) {
            //Caso verdadeiro, é feito um redirecionamento para a rota da Home
            return $router->redirect("auth.login");
        }

        //Continua a rota requisitada caso esteja devidamente autenticado
        return $router->current();
    }

    //Método responsável por verificar se o usuário está autenticado
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
