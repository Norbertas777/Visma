<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.15
 * Time: 12.52
 */

namespace Classes\Side_Functions;


use PDO;
use PDOException;


class Select
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

    private $what = [];

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



    public function select(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function from($table)
    {
        $this->from[] = 'FROM ' . $table;

        return $this;
    }

    public function where($condition)
    {
        $this->where[] = 'WHERE ' . $condition . '=';

        return $this;
    }

    public function what($what)
    {
        $this->what[] = $what;

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            'SELECT %s %s %s %s',
            join(', ', $this->fields),
            join(', ', $this->from),
            join(' , ', $this->where),
            join('AND ', $this->what)
        );
    }


    public function build($queryString)
    {
        $stm = $this->conn->query($queryString)->fetchAll(PDO::FETCH_ASSOC);
        return $stm;
    }
}

