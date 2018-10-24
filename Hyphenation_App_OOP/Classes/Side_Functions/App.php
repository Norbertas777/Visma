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
use Classes\Side_Functions\Database\QueryBuilder;
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
        $insert = new QueryBuilder();
        $connection = new Database();
        $patternList = new PatternDataToArray();

        $patternList->getPatternData();

        $query = $insert->insert('pattern_table')
            ->column('pattern')
            ->values($patternList->getPatternData())
            ->getString('insert');
        $connection->buildWithPrepare($query);
    }

    public function runUsingDB()
    {
        $connection = new Database();
        $select = new QueryBuilder();
        $select2 = new QueryBuilder();
        $select3 = new QueryBuilder();
        $select4 = new QueryBuilder();
        $insert = new QueryBuilder();
        $querry = new DatabaseQ();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();
        $selectAllPatterns = $select->select(['*'])
            ->from('pattern_table')
            ->getString('select');
        $patternArrDB = $connection->buildWithQuery($selectAllPatterns);
        $patternArr = $querry->getPatternData($patternArrDB);
        $selectAllWords = $select2->select(['*'])
            ->from('words_table')
            ->getString('select');
        $wordsArrDB = $connection->buildWithQuery($selectAllWords);
        $wordsArr = $querry->getWordsData($wordsArrDB);
        $selectAllHyphenatedWords = $select3->select(['*'])
            ->from('hyphenated_words_table')
            ->getString('select');
        $hyphenatedArrDB = $connection->buildWithQuery($selectAllHyphenatedWords);
        $hyphenatedArr = $querry->getHyphenatedWordsData($hyphenatedArrDB);

        $wordToInsert = "'".$hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternArr)."'";
        $selectWord =$select4->select(['*'])
            ->from('hyphenated_words_table')
            ->where('hyphenated_word')
            ->what($wordToInsert)
            ->getString('select');

        $checkIfExist = $connection->buildWithQuery($selectWord);

        if (empty($checkIfExist)) {

            $query = $insert->insert('hyphenated_words_table')
                ->column('hyphenated_word')
                ->values($wordToInsert)
                ->getString('insert');
            $connection->buildWithPrepare($query);

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
        $insert = new QueryBuilder();
        $wordToTestList = new PatternDataToArray();

        $wordToTestList->getWordsToTestData();

        $query = $insert->insert('Words_table')
            ->column('word')
            ->values($wordToTestList->getWordsToTestData())
            ->getString('insert');
        $connection->buildWithPrepare($query);
    }
}

