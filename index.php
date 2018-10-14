#!/usr/bin/php7.2

<?php
require __DIR__.'/vendor/autoload.php';

require 'app/bootstrap.php';

echo "*****Welcome to Hyphenator*****\n
    Choose one of the following:\n\n
    file ->Will hyphenate all words that are included in .txt file!\n
    word ->Will hyphenate entered word!\n
    dbWord ->Will choose pattern source as database and hyphenate entered word!\n
    *****Additional*****\n
    -insertPatternDataToDb ->Will insert pattern file content to database.\n
    -insertWordsDataToDb ->Will insert pattern file content to database.\n
    ";

$welcome[] = readline("What would you like to do?");
$case = implode("", $welcome);

$app = new App\App();
$app->runApp($case);
