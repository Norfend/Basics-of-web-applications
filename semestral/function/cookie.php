<?php
declare(strict_types=1);

namespace function;

/**
 * Class cookie
 *
 * A utility class for working with cookies, specifically for setting cookies with an array of values.
 *
 * This class provides a method to set cookies with a JSON-encoded array of values and allows configuration of
 * cookie lifetime and path.
 *
 * @package function
 */
class cookie
{

    private static string $defaultCookiePath = '/';

    private static int $defaultCookieLifetime = 24 * 60 * 60 * 1000;

    /**
     * This method encodes the provided array into a JSON string and sets it as a cookie. It also allows the user
     * to specify the cookie's lifetime in seconds. The cookie will be set with a default path and expiration time
     * based on the specified lifetime.
     *
     * @param string $cookieName The name of the cookie to set.
     * @param array $cookieValue The value of the cookie, which will be JSON-encoded before setting.
     * @param int $cookieLifetime The lifetime of the cookie in seconds. The default lifetime is scaled by the
     *                            value of `cookie::$defaultCookieLifetime` in milliseconds.
     * @return bool Returns `true` if the cookie was successfully set, `false` otherwise.
     */
    public static function set(string $cookieName, array $cookieValue, int $cookieLifetime): bool {
        return setcookie(
            $cookieName,
            json_encode($cookieValue),
            time() + $cookieLifetime * cookie::$defaultCookieLifetime,
            cookie::$defaultCookiePath
        );
    }
}
