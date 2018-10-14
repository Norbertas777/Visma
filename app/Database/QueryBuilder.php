<?php

namespace App\Database;

class QueryBuilder implements DatabaseInterface
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertMany($tableName, $tableRowName, $dataToInstert)
    {

        foreach ($dataToInstert as $dataElement) {

            $query = "INSERT INTO $tableName($tableRowName) VALUES (:pattern)";
            try {
                $stm = $this->pdo->prepare($query);
                $stm->bindParam(':pattern', $dataElement);
                $stm->execute();
            } catch (\Exception $e) {
                return die($e);
            }

        }
    }

    public function insert($tableName, $tableRowName, $dataToInstert)
    {
        $query = "INSERT INTO $tableName($tableRowName) VALUES (:pattern)";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(':pattern', $dataToInstert);
        $stm->execute();

    }

    public function selectAll($selectWhat = "*", $tableName, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName $par";
        return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($selectWhat = "*", $tableName, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName $par";
      return  $this->executeQuery($query);
    }

    public function selectWhere($selectWhat = "*", $tableName, $where, $what, $par = null)
    {
        $query = "SELECT $selectWhat FROM $tableName WHERE $where='$what' $par";
        return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($tableName, $where)
    {
        $query = "DELETE FROM $tableName WHERE $where";
        $this->executeQuery($query);
    }

    public function deleteWhere($tableName, $where, $what)
    {
        $query = "DELETE FROM $tableName WHERE $where=$what";
        $this->executeQuery($query);
    }

    public function clear($tableName)
    {
        $query = "DELETE FROM $tableName";
        $this->executeQuery($query);
    }

    public function update($tableName, $whatToChange, $value, $where, $what)
    {
        $query = "UPDATE $tableName SET $whatToChange='$value' WHERE $where=$what";
        $this->executeQuery($query);
    }


    /**
     * @param $query
     */
    protected function executeQuery($query): void
    {
        try {
            $stm = $this->pdo->prepare($query);
            $stm->execute();
        } catch (\Exception $e) {
             die($e);
        }

    }
}