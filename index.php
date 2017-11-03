<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('SERVERNAME', 'sql1.njit.edu');
define('USERNAME','oe52');
define('PASSWORD','EBFDKE2u');
define('DBNAME','oe52');


class database
{
    protected static $conn;
 function __construct()
 {
     try {
         self::$conn = new PDO('mysql:host='.SERVERNAME.';dbname='.DBNAME , USERNAME, PASSWORD);
         self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         echo 'connected succesfully';
         }
         catch(PDOException $e)
         {
             echo "Error: " . $e->getMessage();
         }
 }

 static function getConnection()
 {
     if(!self::$conn)
     {
        new database;
     }

     return self::$conn;

 }
}


class collection
{
    static function findAll()
    {
        $conn = database::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM '.$tableName;
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $class = static::$modelName;
        $stmt->setFetchMode(PDO::FETCH_CLASS,$class);
        $result= $stmt->fetchAll();
        return $result;

    }
    static function findOne($id)
    {
        $conn = database::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM '.$tableName.' WHERE id = ' .$id;
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $class = static::$modelName;
        $stmt->setFetchMode(PDO::FETCH_CLASS,$class);
        $result= $stmt->fetchAll();
        return $result;

    }
    static function findOneLessThan($id)
    {
        $conn = database::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM '.$tableName.' WHERE id < ' .$id;
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $class = static::$modelName;
        $stmt->setFetchMode(PDO::FETCH_CLASS,$class);
        $result= $stmt->fetchAll();
        return $result;

    }

}

class accounts extends collection
{
        protected static $modelName = 'accounts';
}

class htmlTable
{
    function makeTable($data)
    {
        echo '<table>';

        foreach ($data as $data)
        {
            echo "<tr>";

            foreach ($data as $column) {

                echo "<td>$column</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        }

}


    $obj = new accounts;
    $result = $obj -> findOneLessThan(6);
   $tab = new htmlTable;
   $tab->makeTable($result);