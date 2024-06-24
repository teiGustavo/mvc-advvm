<?php

// Constante de valores para conexão PDO
define('DATA_LAYER_CONFIG', [
    "driver" => $_ENV['DB_DRIVER'] ?? "mysql",
    "host" => $_ENV['DB_HOST'] ?? "localhost",
    "port" => $_ENV['DB_PORT'] ?? "3306",
    "dbname" => $_ENV['DB_NAME'] ?? "advvm",
    "username" => $_ENV['DB_USER'] ?? "root",
    "passwd" => $_ENV['DB_PASSWORD'] ?? "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; SET lc_time_names = 'pt_BR';",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

//Constante de URL base do site
define('APP_URL', $_ENV['APP_URL']);

//Constante que define o nome que acompanha o título das views
define('SITE', $_ENV['VW_TITLE']);

//Constante que define o estado da aplicação
define('APP_ENV', $_ENV['APP_ENV']);

//Constante que define o estado da autenticação
define('NEEDS_AUTH', $_ENV['APP_NEEDS_AUTH']);

//Constante que define o estilo de nome dos arquivos das Planilhas (PhpSpreadSheets)
define('NAME_TEMPLATE', $_ENV['SP_NAME_TEMPLATE']);

//Constante que define a chave secreta e única dos tokens da aplicação
define('JWT_KEY', $_ENV['JWT_KEY']);

define('ROLE_TO_APPROVE', -1);
define('ROLE_ADMINISTRATOR', 1);
define('ROLE_COMMON_USER', 0);
