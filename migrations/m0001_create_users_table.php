<?php

class m0001_create_users_table extends \app\core\database\Migration
{

    public function Up()
    {
        $sql="
            CREATE TABLE users(
                id int auto_increment primary key ,
                name nvarchar(255) not null ,
                email nvarchar(255) not null ,
                status tinyint not null ,
                created_at timestamp default current_timestamp
            )engine=innodb;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }

    public function Down()
    {
        $sql="
            DROP TABLE users;
        ";
        \app\core\Application::$db->pdo->exec($sql);
    }
}