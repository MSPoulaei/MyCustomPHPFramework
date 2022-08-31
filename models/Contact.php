<?php

namespace app\models;

use app\core\Model;
use app\core\Rule;

class Contact extends Model
{
    public string $subject='';
    public string $email='';
    public string $body='';

    public function lables(): array
    {
        return [
            "subject"=>"Subject",
            "email"=>"Your Email",
            "body"=>"Body"
        ];

    }

    protected function rules(): array
    {
        return [
            "subject"=>[Rule::REQUIRED],
            "email"=>[Rule::REQUIRED,Rule::EMAIL],
            "body"=>[Rule::REQUIRED]
        ];
    }
}