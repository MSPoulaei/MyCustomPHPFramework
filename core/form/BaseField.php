<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    protected string $attribute;
    protected Model $model;

    /**
     * @param string $attribute
     * @param Model $model
     */
    public function __construct(string $attribute, Model $model)
    {
        $this->attribute = $attribute;
        $this->model = $model;
    }

    abstract public function renderInputTag():string;

    public function __toString(): string
    {
        $errors="";
        if($this->model->hasError($this->attribute)){
            foreach ($this->model->errors[$this->attribute] as $error){
                $errors.=sprintf('<span class="text-danger validation-error">%s</span>',$error);
            }

        }
        return sprintf(
            '<div class="form-group mt-3">
        <label class="control-label">%s</label>
        %s
        %s
    </div>
    ',
            $this->model->getLable($this->attribute),
            $this->renderInputTag(),
            $errors
        );
    }


}