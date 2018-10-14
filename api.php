<?php
require __DIR__.'/vendor/autoload.php';
use App\Database;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $database = new Database();

        $stm1 = $database->selectWhere('*', 'pattern_table', 'id', $id);

        echo json_encode($stm1);
    } else {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $database = new Database();

        $stm = $database->selectAll('id,pattern', 'pattern_table');

        echo json_encode($stm);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pattern = json_decode(file_get_contents("php://input"), true);
    $database = new Database();
    $database->insert('pattern_table', 'pattern', $pattern['pattern']);

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $patternId = json_decode(file_get_contents("php://input"), true);
    $database = new Database();
    $database->deleteWhere('pattern_table', 'id', $patternId['id']);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $patternUpdate = json_decode(file_get_contents("php://input"), true);
    $database = new Database();
    $database->update('pattern_table', 'pattern', $patternUpdate['pattern'], 'id', $patternUpdate['id']);
}


