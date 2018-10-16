<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.8
 * Time: 12.45
 */

namespace Classes\Side_Functions\Database;

use PDO;
use PDOException;

class Database implements DatabaseInterface
{

    protected $conn;

    public function __construct()
    {
        $db = require_once('Config.php');

        $localhost =$db->localhost;
        $database = $db->database;
        $user = $db->user;
        $password = $db->password;

        try {
            $this->conn = new \PDO("mysql:host=$localhost;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }


    public function insertMany($tableName, $tableRowName, $dataToInstert)
    {

        foreach ($dataToInstert as $dataElement) {

            $query = "INSERT INTO $tableName($tableRowName) VALUES (:pattern)";
            $stm = $this->conn->prepare($query);
            $stm->bindParam(':pattern', $dataElement);
            $stm->execute();
        }
    }

    public function insertIt($tableName, $tableRowName, $dataToInstert)
    {
        $query = "INSERT INTO $tableName($tableRowName) VALUES (:pattern)";
        $stm = $this->conn->prepare($query);
        $stm->bindParam(':pattern', $dataToInstert);
        $stm->execute();

    }

    public function selectAll($selectWhat = "*", $tableName, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName $par";
        $stm = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $stm;
    }

    public function selectIt($selectWhat = "*", $tableName, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName $par";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }

    public function selectWhere($selectWhat = "*", $tableName, $where, $what, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName WHERE $where='$what' $par";
        $stm = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $stm;
    }

    public function deleteIt($tableName, $where)
    {
        $query = "DELETE FROM $tableName WHERE $where";
        $stm = $this->conn->prepare($query);
        $stm->execute();
    }

    public function deleteWhere($tableName, $where, $what)
    {
        $query = "DELETE FROM $tableName WHERE $where=$what";
        $stm = $this->conn->prepare($query);
        $stm->execute();
    }

    public function clear($tableName)
    {
        $query = "DELETE FROM $tableName";
        $stm = $this->conn->prepare($query);
        $stm->execute();
    }

    public function updateIt($tableName, $whatToChange, $value, $where, $what)
    {
        $query = "UPDATE $tableName SET $whatToChange='$value' WHERE $where=$what";
        $stm = $this->conn->prepare($query);
        $stm->execute();
    }
}
