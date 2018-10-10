<?php

namespace Classes\Side_Functions;

interface DatabaseInterface
{
    public function insertMany($tableName,$tableRowName, $dataToInsert);
    public function insert($tableName,$tableRowName, $dataToInsert);
    public function select($selectWhat, $tableName);
    public function selectWhere($selectWhat, $tableName,$where,$what);
    public function delete($tableName, $where);
    public function clear($tableName);
    public function update($tableName,$value);
}