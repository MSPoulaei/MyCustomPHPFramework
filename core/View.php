<?php

namespace app\core;

class View
{
    private string $title="";
    private string $view_path;
    public function __construct()
    {
        $this->view_path =Application::$APP_DIR."/views";;
    }

    public function renderView(string $view,array $params=[],string $layout=""):string
    {
        if ($layout===""){
            $layout=Application::$MAIN_LAYOUT;
        }
        $viewContent=$this->renderViewOnly($view,$params);
        $layoutContent=$this->renderLayout($layout);
        return str_replace("{{content}}",$viewContent,$layoutContent);
    }

    protected function renderLayout($layout)
    {
        ob_start();
        require_once $this->view_path."/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderViewOnly(string $view,array $params=[])
    {
        foreach ($params as $key=>$value){
            $$key=$value;
        }

        ob_start();
        require_once $this->view_path."/$view.php";
        return ob_get_clean();
    }
}