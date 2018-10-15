<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.15
 * Time: 14.28
 */

namespace Classes\Side_Functions;



use PDO;
use PDOException;


class Insert
{


    /**
     * @var array
     */
    private $insert = [];

    /**
     * @var array
     */
    private $values = [];

    protected $conn;

    public function __construct()
    {
        require_once('Config.php');

        try {
            $this->conn = new PDO("mysql:host=$localhost;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }



    public function insert($table)
    {
        $this->insert[] = $table;

        return $this;
    }

    public function values($values)
    {
        $this->values[] = $values;

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            "INSERT INTO %s VALUES ('%s')",
            join(', ', $this->insert),
            join(', ', $this->values)
        );
    }


    public function build($queryString)
    {
        $stm = $this->conn->prepare($queryString);
        $stm->execute();
        return $stm;
    }
}

