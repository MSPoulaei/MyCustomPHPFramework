<?php

namespace app\core\form;

use app\core\Model;

class TextareaField extends BaseField
{
    public function __construct(string $attribute, Model $model)
    {
        parent::__construct($attribute,$model);
    }
    public function renderInputTag(): string
    {
        return sprintf('<textarea name="%s" class="form-control mt-2%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? " is-invalid":"",
            $this->model->{$this->attribute},
        );
    }
}