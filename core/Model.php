<?php

namespace app\core;

abstract class Model
{
    public function loadData($params)
    {
        foreach ($params as $attribute => $value) {
            if (property_exists($this,$attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    protected array $rules = [];

    protected function errorMessages(): array
    {
        return [
            Rule::REQUIRED->name => 'This field is required',
            Rule::EMAIL->name => 'This field must be valid email address',
            Rule::PHONE->name => 'This field must be valid phone number',
            Rule::MIN_LENGTH->name => 'Min length of this field must be {min}',
            Rule::MAX_LENGTH->name => 'Max length of this field must be {max}',
            Rule::MATCH->name => 'This field must be the same as {match}'
        ];
    }

    public array $errors = [];

    public function validate()
    {
        $errorMessages = $this->errorMessages();
        foreach ($this->rules as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                }
                $notValid = ($ruleName === Rule::REQUIRED && !$value)

                    || ($ruleName === Rule::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))

                    || ($ruleName === Rule::PHONE && !filter_var($value, FILTER_SANITIZE_NUMBER_INT))

                    || ($ruleName === Rule::MIN_LENGTH && strlen($value) < $rule["min"])

                    || ($ruleName === Rule::MAX_LENGTH && strlen($value) > $rule["max"])

                    || ($ruleName === Rule::MATCH && $value !== $this->{$rule["match"]});

                if ($notValid) {
                    $errorMsg=$errorMessages[$ruleName->name];
                    if (is_array($rule)) {
                        foreach ($rule as $key => $value){
                            if($value instanceof Rule) continue;
                            $errorMsg=str_replace("{{$key}}",$value,$errorMsg);
                        }
                    }
                    $this->errors[$attribute][] = $errorMsg;
                }
            }
        }
        return empty($this->errors);
    }
}

enum Rule: string
{
    case REQUIRED = "required";
    case EMAIL = "email";
    case PHONE = "phone";
    case MIN_LENGTH = "min";
    case MAX_LENGTH = "max";
    case MATCH = "match";
}