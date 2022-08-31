<?php

class m0003_add_phone_field_to_users_table extends \app\core\database\Migration
{

    public function Up()
    {
        $sql = "
            ALTER TABLE users ADD COLUMN phone nvarchar(255) not null;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }

    public function Down()
    {
        $sql = "
            ALTER TABLE users DROP COLUMN phone;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }
}