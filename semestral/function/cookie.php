<?php
declare(strict_types=1);

namespace function;

class cookie
{
    private static string $defaultCookiePath = '/';
    private static int $defaultCookieLifetime = 24 * 60 * 60 * 1000;

    public static function set(string $cookieName, array $cookieValue, int $cookieLifetime): bool {
        return setcookie($cookieName, json_encode($cookieValue), time() + $cookieLifetime * cookie::$defaultCookieLifetime,
            cookie::$defaultCookiePath);
    }
}