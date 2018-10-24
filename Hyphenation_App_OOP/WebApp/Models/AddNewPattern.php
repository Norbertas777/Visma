<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 17.41
 */

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';
require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/QueryBuilder.php';


use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\QueryBuilder;

class AddNewPattern
{
    public $connection;
    public $insert;

    public function __construct()
    {
        $this->connection = new Database();
        $this->insert = new QueryBuilder();
    }


    public function addPattern()
    {
        if (isset($_POST['pattern'])) {
            $word = $_POST['pattern'];

            $query = $this->insert->insert('pattern_table')
                ->column('pattern')
                ->values($word)
                ->getString('insert');
            $insertIt = $this->connection->buildWithPrepare($query);

            header("Location: /Pattern");
        }
    }
}