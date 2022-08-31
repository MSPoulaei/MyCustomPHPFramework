<?php

namespace app\core\database;

abstract class Migration
{
    abstract public function Up();
    abstract public function Down();
}