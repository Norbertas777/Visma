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

class Database
{

    protected $conn;

    public function __construct()
    {
        $db = include('Config.php');

        $localhost = $db->localhost;
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


    public function buildWithPrepare($queryString)
    {
        $stm = $this->conn->prepare($queryString);
        $stm->execute();
        return $stm;
    }

    public function buildWithQuery($queryString)
    {
        $stm = $this->conn->query($queryString)->fetchAll(\PDO::FETCH_ASSOC);
        return $stm;

    }

    public function buildWithFetch($queryString)
    {
        $stm = $this->conn->query($queryString)->fetch(PDO::FETCH_BOTH);
        return $stm;

    }
}
