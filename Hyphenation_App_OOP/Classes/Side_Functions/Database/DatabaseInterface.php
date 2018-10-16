<?php

namespace Classes\Side_Functions\Database;

interface DatabaseInterface
{
    public function insertMany($tableName, $tableRowName, $dataToInsert);

    public function insertit($tableName, $tableRowName, $dataToInsert);

    public function selectIt($selectWhat, $tableName);

    public function selectWhere($selectWhat, $tableName, $where, $what);

    public function deleteIt($tableName, $where);

    public function clear($tableName);

    public function updateIt($tableName, $whatToChange, $value, $where, $what);
}