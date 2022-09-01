<?php

namespace app\core\Exceptions;

class ForbiddenException extends \Exception
{
    protected $code=403;
    protected $message="Forbidden";
}