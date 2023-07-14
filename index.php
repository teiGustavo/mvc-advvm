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
$router->get("/reports/page/{pagecode}", "AdminController:relatorio", "admin.reports.page");

$router->group("admin/cadastrar",  AuthMiddleware::class);
$router->get("/iniciar", "CadastrarController:selecionarMes", "cadastrar.selecionarMes");
$router->get("/cadastro", "CadastrarController:cadastro", "cadastrar.cadastro");
$router->post("/mes", "CadastrarController:mes", "cadastrar.mes");
$router->post("/create", "CadastrarController:create", "cadastrar.create");

$router->group("admin/excel",  AuthMiddleware::class);
$router->get("/", "AdminController:excel", "admin.excel");
$router->post("/spreadsheet", "AdminController:spreadsheet", "admin.excel.spreadsheet");
$router->post("/download", "AdminController:download", "admin.excel.download");
//$router->get("/spreadsheet/{year}/{month}", "AdminController:excel", "admin.excel");

$router->group("admin/alterar",  AuthMiddleware::class);
$router->get("/", "AlterarController:index", "admin.alterar");
$router->post("/delete", "AlterarController:delete", "alterar.delete");
$router->post("/find", "AlterarController:find", "alterar.find");
$router->post("/update", "AlterarController:update", "alterar.update");

//Define as rotas do grupo de erros HTTP
$router->group("error");
$router->get("/{errcode}", "Web:error");

//Responsável por despachar as rotas
$router->dispatch();

//Verifica se houve alguma requisição via GET de algum erro HTTP
if ($router->error())
    //Caso tenha ocorrido, redireciona para o respectivo erro HTTP
    $router->redirect("/error/{$router->error()}");