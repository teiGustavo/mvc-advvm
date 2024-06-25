<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;
use Advvm\Library\JsonWebToken;

class AuthMiddleware
{
    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router)
    {
        //Verifica se a autenticação está habilitada e se o usuário não está autenticado
        if (filter_var(NEEDS_AUTH, FILTER_VALIDATE_BOOLEAN) == 'true' && $this->isAuth() == false) {
            //Caso verdadeiro, é feito um redirecionamento para a rota da Home
            return $router->redirect("auth.login");
        }

        //Continua a rota requisitada caso esteja devidamente autenticado
        return $router->current();
    }

    //Método responsável por verificar se o usuário está autenticado
    private function isAuth(): bool
    {
        initializeSessions();

        //Recupera o token salvo no cookie ou sessão
        if (!isset($_SESSION["token"]) || $_SESSION["token"] == "") {
            return false;
        }

        if (JsonWebToken::isValid($_SESSION["token"])) {
            return true;
        }

        return false;
    }
}
