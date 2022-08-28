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

    public function isGet():bool
    {
        return $this->getMethod()==="get";
    }
    public function isPost():bool
    {
        return $this->getMethod()==="post";
    }

    public function getBody()
    {
        $body=[];
        $params=null;
        $input_method=null;
        if ($this->isGet()){
            $params=$_GET;
            $input_method=INPUT_GET;
        }
        elseif ($this->isPost()){
            $params=$_POST;
            $input_method=INPUT_POST;
        }
        foreach ($params as $key => $value){
            $body[$key]=filter_input($input_method,$key,FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $body;
    }

}