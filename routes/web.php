<?php

use Advvm\Library\Container;
use CoffeeCode\Router\Router;
use Advvm\Middlewares\AccessControl\AuthMiddleware;
use Advvm\Middlewares\AccessControl\AdminMiddleware;
use Advvm\Middlewares\Validations\Report\ReportCreateValidationMiddleware;
use Advvm\Middlewares\Validations\Report\ReportDeleteValidationMiddleware;
use Advvm\Middlewares\Validations\Report\ReportFindValidationMiddleware;
use Advvm\Middlewares\Validations\Report\ReportUpdateValidationMiddleware;

//Instancia o container de injeção de dependências do PHP-DI
$container = (new Container())->build(['services']);

$router = $container->get(Router::class);

$router->namespace("Advvm\Controllers");

$router->group("", AuthMiddleware::class);
$router->get("/", "HomeController:index", "advvm.home");

$router->group("spreadsheet", AuthMiddleware::class);
$router->get("/", "SpreadsheetController:index", "spreadsheet.index");
$router->post("/find", "SpreadsheetController:findMonthsOfYear", "spreadsheet.findMonths");
$router->post("/download", "SpreadsheetController:download", "spreadsheet.download");
//$router->get("/spreadsheet/{year}/{month}", "SpreadsheetController:download", "spreadsheet");

$router->group("auth");
$router->get("/login", "AuthController:login", "auth.login");
$router->get("/register", "AuthController:register", "auth.register");
$router->get("/logout", "AuthController:logout", "auth.logout");
$router->get("/congrats", "AuthController:congrats", "auth.congrats");
$router->get("/wait", "AuthController:wait", "auth.wait");
$router->get("/forgot", "AuthController:forgot", "auth.forgot");
$router->post("/create-user", "AuthController:createUser", "auth.createUser");
$router->post("/post", "AuthController:post", "auth.post");

$router->group("pagination", AuthMiddleware::class);
$router->get("/page/{pagecode}", "PaginationController:index", "pagination.page");
$router->post("/page/{pagecode}", "PaginationController:pagination", "pagination.page");

$router->group("create",  AuthMiddleware::class);
$router->get("/start", "CreateController:selectMonth", "create.selectMonth");
$router->get("/", "CreateController:reportRegistration", "create.reportRegistration");
$router->post("/", "CreateController:reportRegistration", "create.reportRegistration");

$router->group("reports", AuthMiddleware::class);
$router->post("/create", "ReportController:create", "report.store", ReportCreateValidationMiddleware::class);
$router->post("/find", "ReportController:find", "report.find", ReportFindValidationMiddleware::class);
$router->post("/update", "ReportController:update", "report.update", ReportUpdateValidationMiddleware::class);
$router->post("/delete", "ReportController:delete", "report.delete", ReportDeleteValidationMiddleware::class);

$router->group("users");
$router->post("/find-by-email", "UserController:findByEmail", "user.findByEmail");
$router->post("/update-password", "UserController:updatePassword", "user.updatePassword");

$router->group("users", AuthMiddleware::class);
$router->post("/find", "UserController:find", "user.find");
$router->post("/create", "UserController:create", "user.store");
$router->post("/update", "UserController:update", "user.update");
$router->post("/delete", "UserController:delete", "user.delete");

$router->group("admin", [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/users-to-approval', 'AdminController:index', 'admin');

$router->group("error");
$router->get("/{errcode}", "HomeController:error", 'error');

$router->dispatch();

if ($router->error()) {
    $router->redirect('error', ['errcode' => $router->error()]);
}
