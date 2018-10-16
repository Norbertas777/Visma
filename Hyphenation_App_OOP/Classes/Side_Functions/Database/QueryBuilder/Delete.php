<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.15
 * Time: 14.27
 */

namespace Classes\Side_Functions\Database\QueryBuilder;


use Classes\Side_Functions\Database\Database;

class Delete extends Database
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

    public function delete(array $fields)
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
            'DELETE %s %s %s %s',
            join(', ', $this->fields),
            join(', ', $this->from),
            join(', ', $this->where),
            join(', ', $this->what)
        );
    }


    public function build($queryString)
    {
        $stm = $this->conn->prepare($queryString);
        $stm->execute();
        return $stm;
    }
}

