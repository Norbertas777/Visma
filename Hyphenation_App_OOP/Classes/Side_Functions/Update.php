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


class Update
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $from = [];

    /**
     * @var array
     */
    private $where = [];

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



    public function update(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function set($set)
    {
        $this->from[] = $set;

        return $this;
    }

    public function where($condition)
    {
        $this->where[] = $condition;

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            "UPDATE %s SET %s WHERE %s",
            join(', ', $this->fields),
            join(', ', $this->from),
            join(' AND ', $this->where)
        );
    }


    public function build($queryString)
    {
        $stm = $this->conn->prepare($queryString);
        $stm->execute();
        return $stm;
    }
}

