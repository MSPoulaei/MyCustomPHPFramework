<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Rule;

class Login extends Model
{
    public string $email = "";
    public string $password = "";

    public function login()
    {
        /** @var User $user */
        $user=User::findOne(["email"=>$this->email]);
        if(!$user || !password_verify($this->password,$user->password)){
            $this->AddErrorMessage("password","Email or Password is not correct!");
            return false;
        }
        return Application::$App->login($user);
    }

    protected function rules(): array
    {
        return [
            "email" => [Rule::REQUIRED,Rule::EMAIL],
            "password" => [Rule::REQUIRED],
        ];
    }

    public function lables(): array
    {
        return [
            "email" => "Email",
            "password" => "Password",
        ];
    }
}