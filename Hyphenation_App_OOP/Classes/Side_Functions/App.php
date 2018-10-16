<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.12
 * Time: 11.01
 */

namespace Classes\Side_Functions;

use Classes\Algorithm\PatternDataProxy;
use Classes\Side_Functions\Database\Database;
use Classes\Side_Functions\Database\DatabaseQ;
use Classes\Side_Functions\Timer;
use Classes\Side_Functions\Cache;
use Classes\Side_Functions\Logger;
use Classes\Algorithm\PatternDataToArray;
use Classes\Algorithm\Hyphenation;

include "Autoload.php";

class App
{

    public $container;

    public function __construct()
    {
        $this->container = new \DI\Container();


    }

    public function runApp($case)
    {

        switch ($case) {

            case "-file":

                $this->runFromFile();

                break;

            case "-insertPatternDataToDb":

                $this->insertPatternDataToDB();

                break;

            case "-insertWordsDataToDb":

                $this->insertWordsDataToDB();

                break;

            case "-word":

                $this->runFromWord();

                break;

            case "-dbWord":

                $this->runUsingDB();

                break;
        }
    }


    public function runFromFile()
    {
        $time = new Timer();
        $cache = new Cache('Cache.txt');
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();
        $hyphenateManyWords = new Hyphenation();

        $wordToTestList->getWordsToTestData();

        foreach ($wordToTestList->getWordsToTestData() as $wor) {
            if ($cache->get($wor) !== false) {
                echo $cache->get($wor) . "\r\n";
            } else {

                $patternList->getPatternData();
                $wordToTestList->getWordsToTestData();

                $wordToHyphen->setWordToHyphenate();
                $wordToHyphen->getWordToHyphenate();

                $hyphenateManyWords->echoManyHyphenatedWords($wordToTestList->getWordsToTestData(), $patternList->getPatternData());

                foreach ($wordToTestList->getWordsToTestData() as $word) {

                    $cache->set($word, $hyphenateTheWord->echoHyphenatedWord($word, $patternList->getPatternData()));
                }
            }
        }
        $time->printRunningDuration();
    }

    public function insertPatternDataToDB()
    {
        $connection = new Database();
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();

        $patternList->getPatternData();
        $wordToTestList->getWordsToTestData();

        $connection->insertIt('pattern_table', 'pattern', $patternList->getPatternData());
    }

    public function runUsingDB()
    {
        $connection = new Database();
        $query = new DatabaseQ();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();
        $patternArrDB = $connection->selectIt('*', 'pattern_table');
        $patternArr = $query->getPatternData($patternArrDB);
        $wordsArrDB = $connection->selectIt('*', 'words_table');
        $wordsArr = $query->getWordsData($wordsArrDB);
        $hyphenatedArrDB = $connection->selectIt('*', 'hyphenated_words_table');
        $hyphenatedArr = $query->getHyphenatedWordsData($hyphenatedArrDB);

        $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternArr);
        $checkIfExist = $connection->selectWhere('*', 'hyphenated_words_table', 'hyphenated_word', $wordToInsert);

        if (empty($checkIfExist)) {

            $connection->insertIt('hyphenated_words_table', 'hyphenated_word', $wordToInsert);
            echo "Hyphenated word inserted with success! \n";

        } else {

            echo "Word: " . $wordToHyphen->getWordToHyphenate() . " was already hyphenated and inserted to database!";
        }

//        $connection->select('hyphenated_word','hyphenated_words_table');
//        $connection->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);

//        foreach($wordsArr as $word) {
//
//            $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($word, $patternArr);
//            $connection->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);        // insert many words
//        }
        echo "\n" . $wordToInsert . "\n";
        $matches = $hyphenateTheWord->getPatternMatches($wordToHyphen->getWordToHyphenate(), $patternArr);

        echo "Patterns that match the word entered: " . implode(" ", $matches);
    }

    public function runFromWord()
    {
        $time = new Timer();
        $cache = new Cache('Cache.txt');
        $log = new Logger();

        $patternList = new PatternDataProxy();

        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();

        if ($cache->get($wordToHyphen->getWordToHyphenate()) !== false) {
            echo $cache->get($wordToHyphen->getWordToHyphenate()) . "\r\n";

        } else {

            $patternList->getPatternData();

            echo $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData());

            $time->printRunningDuration();

            $cache->set($wordToHyphen->getWordToHyphenate(), $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));

            $log->log("\nWord to hyphenate: " . $wordToHyphen->getWordToHyphenate(), "Hyphenated word: " . $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));
            $log->logTime($time->getRunningDuration());
        }
    }

    public function insertWordsDataToDB()
    {
        $connection = new Database();
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();

        $patternList->getPatternData();
        $wordToTestList->getWordsToTestData();

        $connection->insertIt('words_table', 'word', $wordToTestList->getWordsToTestData());
    }
}

