<?php

namespace app\core;

class Response
{
    public function setHTTPCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header("Location: $url");
    }
}