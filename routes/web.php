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
$router->get("/", "HomeController:index", "advvm.home");

//Define as rotas do grupo de autenticação (ex: "auth/login")
$router->group("auth");
$router->get("/login", "AuthController:login", "auth.login");
$router->get("/register", "AuthController:register", "auth.register");
$router->get("/logout", "AuthController:logout", "auth.logout");
$router->post("/post", "AuthController:post", "auth.post");

//Define as rotas do grupo admin (ex: "admin/excel")
$router->group("records", AuthMiddleware::class);
$router->get("/", "AdminController:relatorio", "records.list");
$router->get("/page/{pagecode}", "AdminController:relatorio", "records.page");

$router->group("create",  AuthMiddleware::class);
$router->get("/start", "CreateController:selectMonth", "create.selectMonth");
$router->get("/", "CreateController:reportRegistration", "create.reportRegistration");
$router->post("/", "CreateController:reportRegistration", "create.reportRegistration");

$router->group("spreadsheet", AuthMiddleware::class);
$router->get("/", "AdminController:excel", "spreadsheet.selectYear");
$router->post("/", "AdminController:spreadsheet", "spreadsheet.selectMonth");
$router->post("/download", "AdminController:download", "spreadsheet.download");
//$router->get("/spreadsheet/{year}/{month}", "AdminController:excel", "spreadsheet");

$router->group("report", AuthMiddleware::class);
$router->post("/create", "ReportController:create", "report.store");
$router->post("/find", "ReportController:find", "report.find");
$router->post("/update", "ReportController:update", "report.update");
$router->post("/delete", "ReportController:delete", "report.delete");

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
