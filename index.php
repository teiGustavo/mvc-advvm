<?php

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;
use Advvm\Middlewares\AuthMiddleware;

//Instancia um novo roteador na URL base do site
$router = new Router(URL_BASE);

//Define o namespace dos Controllers
$router->namespace("Advvm\Controllers");

//Define as rotas sem um grupo anexo (ex: "/index")
$router->group("", AuthMiddleware::class);
$router->get("/", "HomeController:index", "advvm.home");
$router->get("/read", "ReadController:index", "advvm.read");

//Define as rotas do grupo de autenticação (ex: "auth/login")
$router->group("auth");
$router->get("/login", "AuthController:login", "auth.login");
$router->get("/register", "AuthController:register", "auth.register");
$router->get("/logout", "AuthController:logout", "auth.logout");
$router->post("/post", "AuthController:post", "auth.post");

//Define as rotas do grupo de exemplo / testes de implementação (ex: "example/read")
$router->group("example");
$router->get("/read", "Web:read");
$router->get("/create", "Web:create");
$router->get("/delete", "Web:delete");
$router->get("/update", "Web:update");
$router->get("/phpinfo", "Web:phpinfo");
$router->get("/vardump", "Web:vardump");

//Define as rotas do grupo admin (ex: "admin/excel")
$router->group("admin",  AuthMiddleware::class);
$router->get("/reports", "AdminController:relatorio", "admin.reports");
$router->get("/excel", "AdminController:excel", "admin.excel");
$router->post("/excel/spreadsheet", "AdminController:spreadsheet", "admin.excel.spreadsheet");
$router->post("/excel/download", "AdminController:download", "admin.excel.download");
//$router->get("/excel/spreadsheet/{year}/{month}", "AdminController:excel", "admin.excel");
$router->get("/reports/page/{pagecode}", "AdminController:relatorio", "admin.reports.page");

//Define as rotas do grupo de erros HTTP
$router->group("error");
$router->get("/{errcode}", "Web:error");

//Responsável por despachar as rotas
$router->dispatch();

//Verifica se houve alguma requisição via GET de algum erro HTTP
if ($router->error())
    //Caso tenha ocorrido, redireciona para o respectivo erro HTTP
    $router->redirect("/error/{$router->error()}");