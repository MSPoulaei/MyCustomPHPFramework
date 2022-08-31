<?php

class m0002_add_password_field_to_users_table extends \app\core\database\Migration
{

    public function Up()
    {
        $sql = "
            ALTER TABLE users ADD COLUMN password nvarchar(255) not null;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }

    public function Down()
    {
        $sql = "
            ALTER TABLE users DROP COLUMN password;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }
}