<?php

namespace app\core\database;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract protected static function tableName():string;
    abstract protected function attributes():array;
    public function save()
    {
        $tableName=$this->tableName();
        $attributes=$this->attributes();

        $attributesCommaSeperated=implode(",",$attributes);
        $attributesParametersCommaSeperated=implode(",",array_map( fn($at)=>":".$at,$attributes));
        $sql="INSERT INTO $tableName ($attributesCommaSeperated)
                VALUES ($attributesParametersCommaSeperated)
        ";
        $statement= Application::$db->pdo->prepare($sql);
        foreach ($attributes as $atr){
            $statement->bindValue(":".$atr,$this->{$atr});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $tableName=static::tableName();
        $attributes=array_keys($where);
        $whereClause=implode(" AND ",array_map(fn($atr)=>"$atr = :$atr",$attributes));
        $statement=Application::$db->pdo->prepare("SELECT * FROM $tableName WHERE $whereClause");
        foreach ($where as $atr=>$value){
            $statement->bindValue(":$atr",$value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

}