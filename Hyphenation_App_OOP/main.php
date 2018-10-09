<?php
//
//use Hyphenation_App_OOP\Classes\Side_Functions\Database;
use Hyphenation_App_OOP\Classes\Side_Functions\Timer;
use Hyphenation_App_OOP\Classes\Algorithm\PatternDataToArray;
use Hyphenation_App_OOP\Classes\Algorithm\Hyphenation;


//include ('Classes/Side_Functions/Database.php');
include('Classes/Side_Functions/Timer.php');
include('Classes/Algorithm/PatternDataToArray.php');
include('Classes/Algorithm/Hyphenation.php');


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

        $patternList = new PatternDataToArray();

        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();


        $patternList->setPatternFileLocation('Resources/pattern_data.txt');
        $patternList->getPatternData();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();

        $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData());

        $time->printRunningDuration();

        break;


}