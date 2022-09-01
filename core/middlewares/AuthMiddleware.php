<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\Exceptions\ForbiddenException;

class AuthMiddleware extends Middleware
{
    //if actions is empty it means it executes for every action
    //else it executes for every action every action in this actions array
    private array $actions;

    public function __construct(array $actions=[])
    {
        $this->actions=$actions;
    }

    public function execute()
    {
        if (Application::$App->isGuest()){
            if (empty($this->actions) || in_array(Application::$App->currentAction,$this->actions) ){
                throw new ForbiddenException();
            }

        }
    }
}