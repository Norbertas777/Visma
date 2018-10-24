<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 17.05
 */

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';
require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/QueryBuilder.php';


use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\QueryBuilder;

class AddNewWord
{
    public $connection;
    public $insert;

    public function __construct()
    {
        $this->connection = new Database();
        $this->insert = new QueryBuilder();
    }


    public function addWord()
    {
        if (isset($_POST['word'])) {
            $word = $_POST['word'];

            $query = $this->insert->insert('words_table')
                ->column('word')
                ->values($word)
                ->getString('insert');
            $insertIt = $this->connection->buildWithPrepare($query);

            header("Location: /Words");
        }
    }
}