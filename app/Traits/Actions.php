<?php

namespace App\Traits;

use App\App;
use App\Cache;
use App\DatabaseQ;
use App\Logger;
use App\Timer;
use App\Algorithm\PatternDataToArray;
use App\Algorithm\Hyphenation;

Trait Actions
{

    protected function dbWord()
    {
        $database = App::get('database');
        $query = new DatabaseQ();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();
        $patternArrDB = $database->select('*', 'pattern_table');
        $patternArr = $query->getPatternData($patternArrDB);

        $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternArr);
        $checkIfExist = $database->selectWhere('*', 'hyphenated_words_table', 'hyphenated_word', $wordToInsert);
        if (empty($checkIfExist)) {
            $database->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);
            echo "Hyphenated word inserted with success! \n";
        } else {
            echo "Word: " . $wordToHyphen->getWordToHyphenate() . " was already hyphenated and inserted to database!";
        }

        echo "\n" . $wordToInsert . "\n";
        $matches = $hyphenateTheWord->getPatternMatches($wordToHyphen->getWordToHyphenate(), $patternArr);

        echo "Patterns that match the word entered: " . implode(" ", $matches);
    }

    protected function word()
    {
        $time = new Timer();
        $cache = new Cache('cache.txt');
        $log = new Logger();
        $patternList = new PatternDataToArray();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();

        if ($cache->get($wordToHyphen->getWordToHyphenate()) !== false) {
            echo $cache->get($wordToHyphen->getWordToHyphenate()) . "\r\n";

        } else {
            $patternList->setPatternFileLocation('resources/pattern_data.txt');
            $patternList->getPatternData();
            $wordToHyphen->setWordToHyphenate();
            $wordToHyphen->getWordToHyphenate();

            echo $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData());

            $time->printRunningDuration();
            $cache->set($wordToHyphen->getWordToHyphenate(), $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));
            $log->log("\nWord to hyphenate: " . $wordToHyphen->getWordToHyphenate(), "Hyphenated word: " . $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));
            $log->logTime($time->getRunningDuration());
        }
    }

    protected function insertWordsToDb()
    {
        $database = App::get('database');
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();

        $patternList->setPatternFileLocation('resources/pattern_data.txt');
        $patternList->getPatternData();
        $wordToTestList->setWordsToTestFileLocation('resources/words.txt');
        $wordToTestList->getWordsToTestData();

        $database->insert('words_table', 'word', $wordToTestList->getWordsToTestData());
    }

    protected function insertPatternToDb()
    {
        $database = App::get('database');
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();
        $patternList->setPatternFileLocation('resources/pattern_data.txt');
        $patternList->getPatternData();
        $wordToTestList->setWordsToTestFileLocation('resources/words.txt');
        $wordToTestList->getWordsToTestData();

        $database->insert('pattern_table', 'pattern', $patternList->getPatternData());
    }

    protected function file()
    {
        $time = new Timer();
        $cache = new Cache('cache.txt');
        $wordToTestList = new PatternDataToArray();
        $wordToTestList->setWordsToTestFileLocation('resources/words.txt');
        $words = $wordToTestList->getWordsToTestData();

        foreach ($words as $word) {
            if ($cache->get($word)) {
                echo $cache->get($word) . "\r\n";
            }
        }
        $time->printRunningDuration();
    }
}