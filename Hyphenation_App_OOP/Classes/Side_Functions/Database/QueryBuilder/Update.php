<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.15
 * Time: 14.28
 */

namespace Classes\Side_Functions\Database\QueryBuilder;


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

    private $set = [];

    private $what = [];

    protected $conn;


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

    public function setWhat($set)
    {
        $this->set[] = $set;

        return $this;
    }

    public function where($condition)
    {
        $this->where[] = $condition;

        return $this;
    }

    public function what($condition)
    {
        $this->what[] = $condition;

        return $this;
    }

    public function __toString()
    {
        return sprintf(
            "UPDATE %s SET %s='%s' WHERE %s=%s",
            join(', ', $this->fields),
            join(', ', $this->from),
            join(', ', $this->set),
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

