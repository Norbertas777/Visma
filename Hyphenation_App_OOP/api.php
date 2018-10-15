<?php

use Classes\Side_Functions\Select;
use Classes\Side_Functions\Insert;
use Classes\Side_Functions\Delete;
use Classes\Side_Functions\Update;


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
    }else {

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
    $database->insert('pattern_table', 'pattern', $pattern['pattern']);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $patternId = json_decode(file_get_contents("php://input"), true);
    $database = new Delete();
    $database->delete([''])
             ->from($patternId[0])
             ->where($patternId[]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $patternUpdate = json_decode(file_get_contents("php://input"), true);
    $database = new Update();
    $database->update('pattern_table', 'pattern', $patternUpdate['pattern'], 'id', $patternUpdate['id']);
}


