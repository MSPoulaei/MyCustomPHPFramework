<?php

namespace app\core;

class Session
{
    protected string $flash_key = "flash_messages";

    public function __construct()
    {
        session_start();
        foreach (array_keys($_SESSION[$this->flash_key] ?? []) as $key) {
            $_SESSION[$this->flash_key][$key]["toRemove"] = true;
        }
    }

    public function __destruct()
    {
        foreach ($_SESSION[$this->flash_key] ?? [] as $key => $value) {
            if ($value["toRemove"])
                unset($_SESSION[$this->flash_key][$key]);
        }
    }

    public function setFlash(string $key, $value)
    {
        $_SESSION[$this->flash_key][$key] = [
            "toRemove" => false,
            "value" => $value
        ];
    }

    public function getFlash(string $key)
    {
        return $_SESSION[$this->flash_key][$key]["value"] ?? false;
    }
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }
    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

}