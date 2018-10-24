<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 14.49
 */

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';
require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/QueryBuilder.php';


use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\QueryBuilder;

class DeletePatternsByIdFromDb
{
    public $delete;
    public $connection;

    public function __construct()
    {
        $this->connection = new Database();
        $this->delete = new QueryBuilder();
    }

    public function deletePatternsById(){

        if (isset($_POST['delete']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $query = $this->delete->delete([''])
                ->from('pattern_table')
                ->where('id')
                ->what($id)
                ->getString('delete');
            $deleteIt = $this->connection->buildWithPrepare($query);

            header("Location: /Pattern");
        }
    }


}