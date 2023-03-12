<?php

//Constante de valores para conexao PDO
const DATA_LAYER_CONFIG = [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "id19770428_bd_relatorio",
    "username" => "root",
    "passwd" => "root",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
];

//Constante de URL base do site
const URL_BASE = "http://localhost/mvc-advvm";

//Constante que define o nome que acompanha o título das views
const SITE = "Advvm";

//Constante que define o estilo de nome dos arquivos das Planilhas (PhpSpreadSheets)
const URL_BASE_EXCEL = "Relatorio - Mes ";

//cosntante que define a chave secreta e única dos tokens da aplicação
const JWT_KEY = "DSHWWTSX2566018GT";

function url(string $path): string
{
    if ($path) {
        return URL_BASE . "{$path}";
    }
    return URL_BASE;
}

//Responsável por inicializar as sessões
function initializeSessions(array $sessions = [])
{
    //Verifica se as sessões ja estão iniciadas, senão, as inicia
    if (!isset($_SESSION)) {
        session_start();
    }

    //Inicializa as sessões caso alguma tenha sido passada
    foreach ($sessions as $nameSession => $value) {
        $_SESSION[$nameSession] = $value;
    }

    return true;
}
