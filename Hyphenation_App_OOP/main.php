<?php

use Hyphenation_App_OOP\Classes\Side_Functions\Timer;
use Hyphenation_App_OOP\Classes\Algorithm\PatternDataToArray;
use Hyphenation_App_OOP\Classes\Algorithm\Hyphenation;


include ('Classes/Side_Functions/Timer.php');
include ('Classes/Algorithm/PatternDataToArray.php');
include ('Classes/Algorithm/Hyphenation.php');

$time = new Timer();

$patternList = new PatternDataToArray();
$wordToTestList = new PatternDataToArray();

$wordToHyphen = new Hyphenation();
$hyphenTheWord = new Hyphenation();

$patternList->setPatternFileLocation('Resources/pattern_data.txt');
$patternList->getPatternData();
$wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
$wordToTestList->getWordsToTestData();

$wordToHyphen->setWordToHyphenate();
$wordToHyphen->getWordToHyphenate();
echo $hyphenTheWord->parseWord($wordToHyphen->getWordToHyphenate(),$patternList->getPatternData());

$time->printRunningDuration();