<?php

/**
 * Redirect to provided url
 * @param $url
 */
function redirect($url)
{
    $isExternal = stripos($url, "http://") !== false || stripos($url, "https://") !== false;

    if (!$isExternal) {
        $url = rtrim(SCRIPT_URL, '/') . '/' . ltrim($url, '/');
    }

    if (!headers_sent()) {
        header('Location: ' . $url, true, 302);
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
    }
    exit;
}

/**
 * Get page where user should be redirected, for system workers
 * they get sent to the dashboar while customers get sent back to
 * homepage of shopping website.
 *
 * @return string Page where user should be redirected.
 */
function get_redirect_page()
{
    if (app('login')->isLoggedIn()) {
        $role = app('user')->getRole(SecureSession::get("user_id"));
    }

    $redirect = unserialize(SUCCESS_LOGIN_REDIRECT);
    $system_workers = array("admin, managaer, staff");

    return in_array(strtolower($role), $system_workers) ? $redirect['system_workers'] : $redirect['default'];
}


/**
 * Generates random string.
 *
 * @param int $length
 * @return string
 */
function str_random($length = 16)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

/**
 * Send an HTTP response.
 *
 * @param array $data
 * @param $statusCode
 */
function respond(array $data, $statusCode = 200)
{
    $response = new Response();

    $response->send($data, $statusCode);
}

/**
 * Get container instance or resolve some class/service
 * out of the container.
 * 
 * @param null $service
 * @return mixed
 */
function app($service = null)
{
    $c = Container::getInstance();

    if (is_null($service)) {
        return $c;
    }

    return $c[$service];
}
