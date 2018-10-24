<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.24
 * Time: 11.52
 */

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';
require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/QueryBuilder.php';


use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\QueryBuilder;

class EditPattern
{
    public $connection;
    public $update;
    public $select;

    public function __construct()
    {
        $this->connection = new Database();
        $this->update = new QueryBuilder();
        $this->select = new QueryBuilder();
    }

    public function selectData()
    {
        $id = $_GET['id'];

        $query = $this->select->select(['*'])
            ->from('pattern_table')
            ->where('id')
            ->what($id)
            ->getString('select');
        $selectAll = $this->connection->buildWithQuery($query);

        return $selectAll;

    }

    public function updatePattern()
    {
        if (isset($_POST['pattern']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $word = $_POST['pattern'];

            $query = $this->update->update('pattern_table')
                ->set('pattern')
                ->setWhat($word)
                ->where('id')
                ->what($id)
                ->getString('update');
            $updateIt = $this->connection->buildWithPrepare($query);

            header("Location: /Pattern");
        }
    }
}