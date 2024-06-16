<?php

use CoffeeCode\Router\Router;
use Advvm\Middlewares\AuthMiddleware;


//Instancia um novo roteador na URL base do site
$router = new Router(APP_URL);

//Define o namespace dos Controllers
$router->namespace("Advvm\Controllers");

//Define o middleware de autenticação para todas as rotas
$router->group("", AuthMiddleware::class);

//Define as rotas sem um grupo anexo (ex: "/index")
$router->get("/", "HomeController:index", "advvm.home");

//Define as rotas do grupo de autenticação (ex: "auth/login")
$router->group("auth");
$router->get("/login", "AuthController:login", "auth.login");
$router->get("/register", "AuthController:register", "auth.register");
$router->get("/logout", "AuthController:logout", "auth.logout");
$router->post("/post", "AuthController:post", "auth.post");

//Define as rotas do grupo admin (ex: "admin/excel")
$router->group("admin", AuthMiddleware::class);
$router->get("/reports", "AdminController:relatorio", "admin.reports");
$router->get("/reports/page/{pagecode}", "AdminController:relatorio", "admin.reports.page");

$router->group("admin/cadastrar", AuthMiddleware::class);
$router->get("/iniciar", "CadastrarController:selecionarMes", "cadastrar.selecionarMes");
$router->get("/cadastro", "CadastrarController:cadastro", "cadastrar.cadastro");
$router->post("/mes", "CadastrarController:mes", "cadastrar.mes");
$router->post("/create", "CadastrarController:create", "cadastrar.create");

$router->group("admin/excel", AuthMiddleware::class);
$router->get("/", "AdminController:excel", "admin.excel");
$router->post("/spreadsheet", "AdminController:spreadsheet", "admin.excel.spreadsheet");
$router->post("/download", "AdminController:download", "admin.excel.download");
//$router->get("/spreadsheet/{year}/{month}", "AdminController:excel", "admin.excel");

$router->group("admin/alterar", AuthMiddleware::class);
$router->post("/delete", "AlterarController:delete", "alterar.delete");
$router->post("/find", "AlterarController:find", "alterar.find");
$router->post("/update", "AlterarController:update", "alterar.update");

//Define as rotas do grupo de erros HTTP
$router->group("error");
$router->get("/{errcode}", "HomeController:error");

//Responsável por despachar as rotas
$router->dispatch();

//Verifica se houve alguma requisição via GET de algum erro HTTP
if ($router->error()) {
    //Caso tenha ocorrido, redireciona para o respectivo erro HTTP
    $router->redirect("/error/{$router->error()}");
}