<?php

class SecureSession
{
    public static function startSession()
    {
        session_start();
    }

    public static function destroySession()
    {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );

        session_destroy();
    }

    public static function regenerate($deleteOldSession = true)
    {
        return session_regenerate_id($deleteOldSession);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function destroy($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function get($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return $default;
    }
}
