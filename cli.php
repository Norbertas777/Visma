<?php
require 'app/bootstrap.php';

//    -insertPatternDataToDb ->Will insert pattern file content to database.\n
//    -insertWordsDataToDb ->Will insert pattern file content to database.\n
//TODO:  ^ add these to shell menu options as well

$app = new App\App();
$app->runApp($argv);