<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 14.46
 */

require_once '/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Database/Database.php';

use Classes\Side_Functions\Database\Database;

class PaginationWordsTable
{

    public $connection;

    public function __construct()
    {
        $this->connection = new Database();
    }


    public function paginationForWordsTable()
    {

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        $no_of_records_per_page = 10;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $sql = "SELECT * FROM words_table LIMIT $offset, $no_of_records_per_page";

        $arr = $this->connection->buildWithQuery($sql);

        return $arr;
    }

    public function totalPages(){
        $no_of_records_per_page = 10;

        $total_pages_sql = "SELECT COUNT(*) FROM words_table";
        $result = $this->connection->buildWithFetch($total_pages_sql);
        $total_pages = ceil($result[0] / $no_of_records_per_page);

        return $total_pages;
    }
}