<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.15
 * Time: 14.28
 */

namespace Classes\Side_Functions\Database\QueryBuilder;


use Classes\Side_Functions\Database\Database;

class Insert extends Database
{


    /**
     * @var array
     */
    private $insert = [];

    /**
     * @var array
     */
    private $values = [];

    private $column = [];

    protected $conn;


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

    public function column($column)
    {
        $this->column[] = $column;

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            "INSERT INTO %s (%s) VALUES ('%s')",
            join(', ', $this->insert),
            join(', ', $this->column),
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

