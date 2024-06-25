<?php

use Advvm\Library\Session;

function url(string $path): string
{
    if ($path) {
        return APP_URL . "{$path}";
    }
    return APP_URL;
}

function base64url_encode(string $string): string|false
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
}

function base64url_decode(string $string): string|false
{
    return base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
}

function flash(string $index): mixed
{
    return Session::get('__flash')[$index] ?? null;
}