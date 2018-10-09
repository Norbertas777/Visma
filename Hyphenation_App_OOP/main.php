<?php
//
//use Hyphenation_App_OOP\Classes\Side_Functions\Database;
use Classes\Side_Functions\Timer;
use Classes\Side_Functions\Logger;
use Classes\Algorithm\PatternDataToArray;
use Classes\Algorithm\Hyphenation;


//include ('Classes/Side_Functions/Database.php');
//include('Classes/Side_Functions/Timer.php');
//include('Psr/Log/AbstractLogger.php');
//include('Classes/Side_Functions/Logger.php');
//include('Classes/Algorithm/PatternDataToArray.php');
//include('Classes/Algorithm/Hyphenation.php');

spl_autoload_register(function ($class) {

    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (file_exists($file)) {

        require $file;

        return true;
    }
    return false;
});


//$connection = new Database();
switch ($argv[1]) {

    case "-file":

        $time = new Timer();

        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();


        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();
        $hyphenateManyWords = new Hyphenation();

        $patternList->setPatternFileLocation('Resources/pattern_data.txt');
        $patternList->getPatternData();
        $wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
        $wordToTestList->getWordsToTestData();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();


        $hyphenateManyWords->echoManyHyphenatedWords($wordToTestList->getWordsToTestData(), $patternList->getPatternData());

        $time->printRunningDuration();

        break;

    case "-word":

        $time = new Timer();

        $log = new Logger();

        $patternList = new PatternDataToArray();

        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();


        $patternList->setPatternFileLocation('Resources/pattern_data.txt');
        $patternList->getPatternData();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();

        echo $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData());

        $time->printRunningDuration();

        $log->log("\nWord to hyphenate: ".$wordToHyphen->getWordToHyphenate(), "Hyphenated word: ".$hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));
        $log->logTime($time->getRunningDuration());

        break;


}