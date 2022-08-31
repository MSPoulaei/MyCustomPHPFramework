<?php

namespace app\models;

use app\core\Model;
use app\core\Rule;

class Register extends Model
{
    public string $name="";
    public string $email="";
    public string $phone="";
    public string $password="";
    public string $confirmPassword="";
    protected array $rules=[
        "name"=>[Rule::REQUIRED],
        "email"=>[Rule::REQUIRED,Rule::EMAIL],
        "phone"=>[Rule::REQUIRED,Rule::PHONE],
        "password"=>[Rule::REQUIRED,[Rule::MIN_LENGTH,"min"=>8],[Rule::MAX_LENGTH,"max"=>24]],
        "confirmPassword"=>[Rule::REQUIRED,[Rule::MATCH,"match"=>"password"]]
    ];

    public function lables(): array
    {
        return [
            "name"=>"Your Name",
            "email"=>"Your Email",
            "phone"=>"Your Phone Number",
            "password"=>"Password",
            "confirmPassword"=>"Confirm Password",
        ];
    }
}