<?php


use Classes\Side_Functions\Database\QueryBuilder\Insert;
use Classes\Side_Functions\Database\QueryBuilder\Select;
use Classes\Side_Functions\Database\QueryBuilder\Update;
use Classes\Side_Functions\Database\QueryBuilder\Delete;


include "Classes/Side_Functions/Autoload.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {

        $queries = $_SERVER['REQUEST_URI'];
        $sanitize = preg_replace('/[?&=]/', '/', $queries);
        $urlArray = explode('/', $sanitize);


        $select = new Select();

        $query = $select->select(['*'])
            ->from($urlArray[2])
            ->__toString();

        $returnQuery = $select->build($query);

        echo json_encode($returnQuery);
    } else {

        $queries = $_SERVER['REQUEST_URI'];
        $sanitize = preg_replace('/[?&=]/', '/', $queries);
        $urlArray = explode('/', $sanitize);

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");


        $select = new Select();

        $query = $select->select(['*'])
            ->from($urlArray[2])
            ->where($urlArray[3])
            ->what($urlArray[4])
            ->__toString();

        $returnQuery = $select->build($query);

        echo json_encode($returnQuery);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pattern = json_decode(file_get_contents("php://input"), true);

    $database = new Insert();

    $query = $database->insert($pattern['tablename'])
        ->column($pattern['columnname'])
        ->values($pattern['value'])
        ->__toString();
    $returnQuery = $database->build($query);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $patternId = json_decode(file_get_contents("php://input"), true);

    $database = new Delete();

    $query = $database->delete([''])
        ->from($patternId['pattern_table'])
        ->where('id')
        ->what($patternId['id'])
        ->__toString();
    $returnQuery = $database->build($query);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $patternUpdate = json_decode(file_get_contents("php://input"), true);

    $database = new Update();

    $query = $database->update($patternUpdate['tablename'])
        ->set($patternUpdate['columnname'])
        ->setWhat($patternUpdate['value'])
        ->where('id')
        ->what($patternUpdate['id'])
        ->__toString();
    $returnQuery = $database->build($query);
}


