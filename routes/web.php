<?php

use Advvm\Library\Container;
use CoffeeCode\Router\Router;
use Advvm\Middlewares\AuthMiddleware;

//Instancia o container de injeção de dependências do PHP-DI
$container = (new Container())->build(['services']);

//Instancia um novo roteador na URL base do site
$router = $container->get(Router::class);

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

$router->group("create",  AuthMiddleware::class);
$router->get("/start", "CreateController:selectMonth", "create.selectMonth");
$router->get("/", "CreateController:reportRegistration", "create.reportRegistration");
$router->post("/", "CreateController:reportRegistration", "create.reportRegistration");
$router->post("/store", "ReportController:create", "create.store");

$router->group("admin/excel", AuthMiddleware::class);
$router->get("/", "AdminController:excel", "admin.excel");
$router->post("/spreadsheet", "AdminController:spreadsheet", "admin.excel.spreadsheet");
$router->post("/download", "AdminController:download", "admin.excel.download");
//$router->get("/spreadsheet/{year}/{month}", "AdminController:excel", "admin.excel");

$router->group("admin/alterar", AuthMiddleware::class);
$router->post("/delete", "ReportController:delete", "alterar.delete");
$router->post("/find", "ReportController:find", "alterar.find");
$router->post("/update", "ReportController:update", "alterar.update");

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
