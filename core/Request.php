<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $pathWithQueryString=$_SERVER["REQUEST_URI"];
        list($path)=explode('?',$pathWithQueryString);
        return strtolower($path);
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}