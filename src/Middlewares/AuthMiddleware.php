<?php

namespace Advvm\Middlewares;

use CoffeeCode\Router\Router;

class AuthMiddleware
{
    //Teste de implementação de um controlador da rota de login
    public function handle(Router $router)
    {
        //Verifica se o usuário não está autenticado
        if ($this->isAuth() == false) {
            //Caso verdadeiro, é feito um redirecionamento para a rota da Home
            return $router->redirect("advvm.home", ["isAuth" == false]);
        }

        //Continua a rota requisitada caso esteja devidamente autenticado
        return $router->current();
    }

    //Método responsável por verificar se o usuário está autenticado
    private function isAuth(): bool
    {
        //Função que inicializa as sessões (Presente no Config.php)
        initializeSessions();

        //Verifica se o usuário está logado
        if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
            return true;
        }

        //Retorna falso caso o usuário não tenha feito login
        return false;
    }
}