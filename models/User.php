<?php

namespace app\models;

use app\core\database\DbModel;
use app\core\Model;
use app\core\Rule;
use app\core\UserModel;

class User extends UserModel
{
    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public string $password = "";
    public string $confirmPassword = "";
    public int $status;

    public function __construct()
    {
        $this->status=Status::INACTIVE->value;
    }

    public function save()
    {
        $this->password=password_hash($this->password,PASSWORD_DEFAULT);
        return parent::save(); // TODO: Change the autogenerated stub
    }

    protected function rules(): array
    {
        return [
            "name" => [Rule::REQUIRED],
            "email" => [Rule::REQUIRED, Rule::EMAIL,[Rule::UNIQUE,"class"=>static::class,"unique"=>$this->getLable("email")]],
            "phone" => [Rule::REQUIRED, Rule::PHONE],
            "password" => [Rule::REQUIRED, [Rule::MIN_LENGTH, "min" => 8], [Rule::MAX_LENGTH, "max" => 24]],
            "confirmPassword" => [Rule::REQUIRED, [Rule::MATCH, "match" => "password"]]
        ];
    }

    public function lables(): array
    {
        return [
            "name" => "Your Name",
            "email" => "Your Email",
            "phone" => "Your Phone Number",
            "password" => "Password",
            "confirmPassword" => "Confirm Password",
        ];
    }

    protected static function tableName(): string
    {
        return "users";
    }
    public  static function primaryKey(): string
    {
        return "id";
    }

    protected function attributes(): array
    {
        return [
            "name",
            "email",
            "phone",
            "password",
            "status"
        ];
    }

    public function getFullName(): string
    {
        return $this->name;
    }
}

enum Status:int{
    case INACTIVE=0;
    case ACTIVE=1;
    case DELETED=2;
}