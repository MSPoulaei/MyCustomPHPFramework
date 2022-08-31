<?php

namespace app\models;

use app\core\Model;
use app\core\Rule;

class Contact extends Model
{
    public string $subject='';
    public string $email='';
    public string $body='';
    protected array $rules=[
        "subject"=>[Rule::REQUIRED],
        "email"=>[Rule::REQUIRED,Rule::EMAIL],
        "body"=>[Rule::REQUIRED]
    ];

    public function lables(): array
    {
        return [
            "subject"=>"Subject",
            "email"=>"Your Email",
            "body"=>"Body"
        ];

    }
}