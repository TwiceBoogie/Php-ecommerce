<?php

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

function respond(array $data, $statusCode = 200)
{
    $response = new Response();

    $response->send($data, $statusCode);
}

function app($service = null)
{
    $c = Container::getInstance();

    if (is_null($service)) {
        return $c;
    }

    return $c[$service];
}
