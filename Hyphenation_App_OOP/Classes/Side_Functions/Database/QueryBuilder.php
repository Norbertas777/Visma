<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.17
 * Time: 15.14
 */

namespace Classes\Side_Functions\Database;

class QueryBuilder
{

    //insert
    private $insert = [];
    private $values =[];
    private $column =[];

//delete
    private $fields =[];
    private $from =[];
    private $where =[];
    private $what =[];

//update
    private $set =[];
    private $update  =[];
    private $columnName =[];

    private $limit = [];

    public function select(array $fields)
    {
        $this->fields = $fields;

        return $this;
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

    public function column($column)
    {
        $this->column[] = $column;

        return $this;
    }

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

    public function update($table)
    {
        $this->update[] = $table;

        return $this;
    }

    public function limit($number)
    {
        $this->limit[] ='LIMIT ' . $number;

        return $this;
    }

    public function set($columnName)
    {
        $this->columnName[] = $columnName;

        return $this;
    }

    public function setWhat($set)
    {
        $this->set[] = $set;

        return $this;
    }

    public function getString($case)
    {
        if ($case == 'insert') {

            return sprintf(
                "INSERT INTO %s (%s) VALUES ('%s')",
                join(', ', $this->insert),
                join(', ', $this->column),
                join(', ', $this->values)
            );
        } elseif ($case == 'delete') {

            return sprintf(
                "DELETE %s %s %s'%s'",
                join(', ', $this->fields),
                join(', ', $this->from),
                join(', ', $this->where),
                join(', ', $this->what)
            );
        } elseif ($case == 'update') {

            return sprintf(
                "UPDATE %s SET %s='%s' %s'%s'",
                join(', ', $this->update),
                join(', ', $this->columnName),
                join(', ', $this->set),
                join(', ', $this->where),
                join(', ', $this->what)
            );
        } elseif ($case == 'select') {

            return sprintf(
                "SELECT %s %s %s %s %s",
                join('', $this->fields),
                join(', ', $this->from),
                join(' ,', $this->where),
                join(' AND ', $this->what),
                join(' AND ', $this->limit)
            );
        }
    }

}