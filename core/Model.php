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

    abstract protected function rules():array;

    protected function errorMessages(): array
    {
        return [
            Rule::REQUIRED->name => 'This field is required',
            Rule::EMAIL->name => 'This field must be valid email address',
            Rule::PHONE->name => 'This field must be valid phone number',
            Rule::MIN_LENGTH->name => 'Min length of this field must be {min}',
            Rule::MAX_LENGTH->name => 'Max length of this field must be {max}',
            Rule::MATCH->name => 'This field must be the same as {match}',
            Rule::UNIQUE->name => 'A record with the same {unique} already exists'
        ];
    }

    protected array $errors = [];

    public function AddErrorMessage(string $attribute,string $message)
    {
        $this->errors[$attribute][]=$message;
    }
    public function validate()
    {
        $errorMessages = $this->errorMessages();
        foreach ($this->rules() as $attribute => $rules) {
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

                if($ruleName===Rule::UNIQUE){
                    $className=$rule["class"];
                    if($className::findOne([$attribute=>$value])){
                        $notValid=true;

                    }
                }

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

    abstract public function lables():array;

    public function getLable(string $attribute)
    {
        return $this->lables()[$attribute] ?? $attribute;
    }
    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
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
    case UNIQUE = "unique";
}