<?php

use Advvm\Library\Container;
use CoffeeCode\Router\Router;
use Advvm\Middlewares\AuthMiddleware;
use Advvm\Middlewares\AdminMiddleware;

//Instancia o container de injeção de dependências do PHP-DI
$container = (new Container())->build(['services']);

//Instancia um novo roteador na URL base do site
$router = $container->get(Router::class);

//Define o namespace dos Controllers
$router->namespace("Advvm\Controllers");

//Define o middleware de autenticação para todas as rotas
$router->group("", AuthMiddleware::class);
$router->get("/", "HomeController:index", "advvm.home");

$router->group("spreadsheet", AuthMiddleware::class);
$router->get("/", "SpreadsheetController:index", "spreadsheet.index");
$router->post("/find", "SpreadsheetController:findMonthsOfYear", "spreadsheet.findMonths");
$router->post("/download", "SpreadsheetController:download", "spreadsheet.download");
//$router->get("/spreadsheet/{year}/{month}", "SpreadsheetController:download", "spreadsheet");

//Define as rotas do grupo de autenticação (ex: "auth/login")
$router->group("auth");
$router->get("/login", "AuthController:login", "auth.login");
$router->get("/register", "AuthController:register", "auth.register");
$router->get("/logout", "AuthController:logout", "auth.logout");
$router->post("/post", "AuthController:post", "auth.post");

$router->group("pagination", AuthMiddleware::class);
$router->get("/page/{pagecode}", "PaginationController:index", "pagination.page");
$router->post("/page/{pagecode}", "PaginationController:pagination", "pagination.page");

$router->group("create",  AuthMiddleware::class);
$router->get("/start", "CreateController:selectMonth", "create.selectMonth");
$router->get("/", "CreateController:reportRegistration", "create.reportRegistration");
$router->post("/", "CreateController:reportRegistration", "create.reportRegistration");

$router->group("reports", AuthMiddleware::class);
$router->post("/create", "ReportController:create", "report.store");
$router->post("/find", "ReportController:find", "report.find");
$router->post("/update", "ReportController:update", "report.update");
$router->post("/delete", "ReportController:delete", "report.delete");

$router->group("users", AuthMiddleware::class);
$router->post("/create", "UserController:create", "user.store");
$router->post("/find", "UserController:find", "user.find");
$router->post("/update", "UserController:update", "user.update");
$router->post("/delete", "UserController:delete", "user.delete");

$router->group("admin", [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/users-to-approval', 'AdminController:index', 'admin');

//Define as rotas do grupo de erros HTTP
$router->group("error");
$router->get("/{errcode}", "HomeController:error", 'error');

//Responsável por despachar as rotas
$router->dispatch();

//Verifica se houve alguma requisição via GET de algum erro HTTP
if ($router->error()) {
    //Caso tenha ocorrido, redireciona para o respectivo erro HTTP
    $router->redirect("/error/{$router->error()}");
}
