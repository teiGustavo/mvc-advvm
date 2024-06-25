<?php

namespace Advvm\Library;

class Session
{
    public static function set(string $index, mixed $value): void
    {
        $_SESSION[$index] = $value;
    }

    public static function has(string $index): bool
    {
        return isset($_SESSION[$index]);
    }

    public static function get(string $index): mixed
    {
        if (self::has($index)) {
            return $_SESSION[$index];
        }

        return null;
    }

    public static function remove(string $index): mixed
    {
        if (self::has($index)) {
            unset($_SESSION[$index]);
        }

        return null;
    }

    public static function removeAll(): mixed
    {
        session_destroy();
    }

    public static function flash(string $index, mixed $value): void
    {
        $_SESSION['__flash'][$index] = $value;
    }

    public static function removeFlash(): mixed
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && self::has('__flash')) {
            unset($_SESSION['__flash']);
        }

        return null;
    }

    public static function dump(): void
    {
        var_dump($_SESSION);
    }
}
