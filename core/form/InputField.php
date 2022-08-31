<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    protected InputType $type;

    /**
     * @param InputType $type
     */
    public function __construct(string $attribute, Model $model,InputType $type=InputType::TEXT)
    {
        $this->type= $type;
        parent::__construct($attribute,$model);
    }
    public function renderInputTag(): string
    {
        return sprintf('<input name="%s" type="%s" value="%s"  class="form-control mt-2%s" />',
            $this->attribute,
            $this->type->value,
            $this->model->{$this->attribute} ,
            $this->model->hasError($this->attribute) ? " is-invalid":"",
        );
    }

}
enum InputType:string{
    case TEXT="text";
    case EMAIL="email";
    case NUMBER="number";
    case PASSWORD="password";
}