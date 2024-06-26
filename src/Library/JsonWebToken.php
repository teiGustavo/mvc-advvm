<?php

namespace Advvm\Library;

class JsonWebToken
{
    public static function generate(array $credentials): string|false
    {
        if (in_array('', $credentials)) {
            return false;
        }

        // Verifica se o array não segue o formato ['key' => 'value']
        foreach (array_keys($credentials) as $key) {
            if (is_int($key)) {
                return false;
            }
        }

        $expTime = time() + (1 * 1 * 60 * 60); //(Dias * Horas * Minutos * Segundos)

        //Cabeçalho do token (Primeira parte do token JWT)
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = base64url_encode(json_encode($header));

        //Segunda parte do token JWT (Carga útil)
        $payload = [
            'iss' => APP_URL,
            'aud' => APP_URL,
            'exp' => $expTime,
            ...$credentials
        ];

        $payload = base64url_encode(json_encode($payload));

        $signature = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));

        if (is_bool($header) || is_bool($payload) || is_bool($signature)) {
            return false;
        }

        return "$header.$payload.$signature";
    }

    public static function isValid(string $token): bool
    {
        [$header, $payload, $signature] = explode(".", $token);

        $validateSignature = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));

        if ($signature === $validateSignature) {
            $date = json_decode(base64url_decode($payload));

            if ($date->exp > time()) {
                return true;
            }
        }

        return false;
    }

    public static function decode(string $token): array
    {
        if (self::isValid($token)) {
            [, $payload] = explode(".", $token);

            return json_decode(base64url_decode($payload), true);
        }

        return [];
    }
}
