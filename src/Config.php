<?php

function url(string $path): string
{
    if ($path) {
        return APP_URL . "{$path}";
    }
    return APP_URL;
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

//Responsável por formatar os valores em float para o padrão do SQL
function formatFloatToSqlPattern(string $float)
{
    if (str_contains($float, ',')) {
        $float = str_replace('.', '', $float);
        $float = str_replace(',', '.', $float);
    }

    return $float;
}

function base64url_encode(string $string): string|false
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
}

function base64url_decode(string $string): string|false
{
    return base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
}
