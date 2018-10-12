<?php

use Classes\Side_Functions\App;


include "Classes/Side_Functions/Autoload.php";

$welcomeMsg = "*****Welcome to Hyphenator*****\n\n
Choose one of the following:\n\n
-file ->Will hyphenate all words that are included in .txt file!\n
-word ->Will hyphenate entered word!\n
-dbWord ->Will choose pattern source as database and hyphenate entered word!\n\n
*****Additional*****\n\n
-insertPatternDataToDb ->Will insert pattern file content to database.\n
-insertWordsDataToDb ->Will insert pattern file content to database.\n
";

echo $welcomeMsg;

$welcome[] = readline("What would you like to do?");
$case = implode("", $welcome);

$app = new App();
$app->runApp($case);
