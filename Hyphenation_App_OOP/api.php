<?php

use Classes\Side_Functions\Database\Database;

include "Classes/Side_Functions/Autoload.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {

        $queries = $_SERVER['REQUEST_URI'];
        $sanitize = preg_replace('/[?&=]/', '/', $queries);
        $urlArray = explode('/', $sanitize);


        $select = new Database();

        $query = $select->select(['*'])
            ->from($urlArray[2])
            ->getString('select');

        $returnQuery = $select->buildWithQuery($query);

        echo json_encode($returnQuery);
    } else {

        $queries = $_SERVER['REQUEST_URI'];
        $sanitize = preg_replace('/[?&=]/', '/', $queries);
        $urlArray = explode('/', $sanitize);

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");


        $select = new Database();

        $query = $select->select(['*'])
            ->from($urlArray[2])
            ->where($urlArray[3])
            ->what($urlArray[4])
            ->getString('select');

        $returnQuery = $select->buildWithQuery($query);

        echo json_encode($returnQuery);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pattern = json_decode(file_get_contents("php://input"), true);

    $database = new Database();

    $query = $database->insert($pattern['tablename'])
        ->column($pattern['columnname'])
        ->values($pattern['value'])
        ->getString('insert');
    $returnQuery = $database->buildWithPrepare($query);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $patternId = json_decode(file_get_contents("php://input"), true);

    $database = new Database();

    $query = $database->delete([''])
        ->from($patternId['pattern_table'])
        ->where('id')
        ->what($patternId['id'])
        ->getString('delete');
    $returnQuery = $database->buildWithPrepare($query);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $patternUpdate = json_decode(file_get_contents("php://input"), true);

    $database = new Database();

    $query = $database->update($patternUpdate['tablename'])
        ->set($patternUpdate['columnname'])
        ->setWhat($patternUpdate['value'])
        ->where('id')
        ->what($patternUpdate['id'])
        ->getString('update');
    $returnQuery = $database->buildWithPrepare($query);
}


