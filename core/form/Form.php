<?php

namespace app\core\form;

class Form
{
    public static function Begin(string $action,string $method)
    {
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new static();
    }

    public function submitBtn(string $textBtn="Submit")
    {
        echo sprintf('
    <button type="submit" class="btn btn-primary btn-lg mt-3">%s</button>
',$textBtn);
    }
    public function End()
    {
        echo "</form>";
    }
}