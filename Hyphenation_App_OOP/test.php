<?php



use Classes\Side_Functions\Select;
use Classes\Side_Functions\Update;
use Classes\Side_Functions\Delete;
use Classes\Side_Functions\Insert;

include "Classes/Side_Functions/Autoload.php";



$sql = new Insert();

$info= $sql->insert('hyphenated_words_table(hyphenated_word)')
    ->values("labas")
    ->__toString();

echo $info;
$update = $sql->build($info);