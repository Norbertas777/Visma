<?php

namespace Classes\Side_Functions\Database;

interface QueryBuilderInterface
{
    public function insert($table);

    public function select(array $fields);

    public function delete(array $fields);

    public function update($table);

    public function values($values);

    public function column($column);

    public function from($table);

    public function where($condition);

    public function what($what);

    public function set($columnName);

    public function setWhat($set);
   }