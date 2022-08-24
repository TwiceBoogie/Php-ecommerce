<?php

/**
 * Response class.
 */
class Response
{
    protected $statuses = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',


        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        415 => 'Unsupported Media Type',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
    );

    public function send(array $data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        $this->setStatusHeader($statusCode);
        echo json_encode($data);
        exit;
    }

    private function setStatusHeader($code = 200)
    {
        $text = isset($this->statuses[$code])
            ? $this->statuses[$code]
            : 'Unknown';

        $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : false;

        if (substr(php_sapi_name(), 0, 3) == 'cgi') {
            header("Status: {$code} {$text}", true);
        } elseif ($server_protocol == 'HTTP/1.1' or $server_protocol == 'HTTP/1.0') {
            header($server_protocol . " {$code} {$text}", true, $code);
        } else {
            header("HTTP/1.1 {$code} {$text}", true, $code);
        }
    }
}
