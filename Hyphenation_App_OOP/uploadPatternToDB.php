<?php

require 'Config.php';

$fileloc = readline('Enter file location:');

$patterns = explode("\n", file_get_contents($fileloc));

$checkTableContent = $pdo->prepare("SELECT * FROM pattern_table");
$checkTableContent->execute();


foreach ($patterns as $key =>$patternToInsert) {

    if ($checkTableContent->rowCount() > 0) {

        $sql = $pdo->prepare("UPDATE pattern_table SET pattern = '.$patternToInsert.' WHERE id =".$key);

        $sql->execute();

//        $sql = $pdo->prepare("INSERT INTO pattern_table (pattern) VALUE (:pattern)");
//
//        $sql->bindParam(':pattern', $patternToInsert);
//
//        $sql->execute();



    } else {

        $sql = $pdo->prepare("INSERT INTO pattern_table (pattern) VALUE (:pattern)");

        $sql->bindParam(':pattern', $patternToInsert);

        $sql->execute();

    }


}

