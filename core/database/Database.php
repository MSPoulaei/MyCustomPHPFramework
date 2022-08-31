<?php

namespace app\core\database;

use app\core\Application;

class Database
{
    public \PDO $pdo;
    public function __construct($config)
    {
        $dsn =$config["dsn"];
        $username =$config["username"];
        $password =$config["password"];
        $this->pdo=new \PDO($dsn,$username,$password);
        $this->pdo->setAttribute(\PDO::ERRMODE_EXCEPTION,\PDO::ATTR_ERRMODE);
    }

    public function ApplyMigrations()
    {
        $this->ensureMigrationTableCreated();
        $toApplyMigs=$this->getToApplyMigrationsFileNames();
        if (empty($toApplyMigs)) return;
        foreach ($toApplyMigs as $mig){
            $className=pathinfo(Application::$APP_DIR."/migrations/".$mig,PATHINFO_FILENAME);
            require_once Application::$APP_DIR."/migrations/".$mig;
            $instance=new $className();
            $instance->up();
            echo "Migration $className applied".PHP_EOL;
        }
        $this->insertMigs($toApplyMigs);
    }

    private function insertMigs(array $migs)
    {
        $migs=implode(",", array_map(fn($mig)=>"('$mig')",$migs));
        $this->pdo->exec("INSERT INTO migrations_history(migration_name) VALUES $migs");
    }

    private function getToApplyMigrationsFileNames()
    {
        $alreadyAppliedMigs=$this->getMigrationsFromDb();
        $availableMigs=$this->getMigrationsFileNamesFromFolder();
        return array_diff($availableMigs,$alreadyAppliedMigs);
    }

    private function getMigrationsFileNamesFromFolder()
    {
        return array_diff(scandir(Application::$APP_DIR."/migrations"),[".",".."]);
    }
    private function getMigrationsFromDb()
    {
        $sql='
            SELECT migration_name
            FROM migrations_history;
        ';
        $query=$this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function ensureMigrationTableCreated()
    {
        $sql='
            CREATE TABLE IF NOT EXISTS migrations_history(
                id int auto_increment primary key,
                migration_name nvarchar(255) not null ,
                created_at timestamp default current_timestamp
            ) ENGINE=INNODB;
        ';
        $this->pdo->exec($sql);
    }

}