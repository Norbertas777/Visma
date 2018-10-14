<?php

namespace App\Traits;

use App\App;
use App\Cache;
use App\DatabaseQ;
use App\Logger;
use App\Timer;
use App\Algorithm\Hyphenation;

Trait Actions
{

    protected function dbWord($word)
    {
        $database = App::get('database');
        $query = new DatabaseQ();
        $hyphenateTheWord = new Hyphenation();

        $patternArrDB = $database->select('*', 'pattern_table');

        $patternArr = $query->getPatternData($patternArrDB);
        $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($word, $patternArr);
        $checkIfExist = $database->selectWhere('*', 'hyphenated_words_table', 'hyphenated_word', $wordToInsert);
        if (empty($checkIfExist)) {
            $database->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);
            echo "Hyphenated word inserted with success! \n";
        } else {
            echo "Word: $word was already hyphenated and inserted to database!";
        }

        echo "\n" . $wordToInsert . "\n";
        $matches = $hyphenateTheWord->getPatternMatches($word, $patternArr);

        echo "Patterns that match the word entered: " . implode(" ", $matches);
    }

    protected function word($word)
    {
        $time = new Timer();
        $cache = new Cache('cache.txt');
        $log = new Logger();
        $patternData = $this->fileToArray('resources/pattern_data.txt');
        $hyphenateTheWord = new Hyphenation();

        if ($cache->get($word)) {
            echo $cache->get($word) . "\r\n";
        } else {
            echo $hyphenateTheWord->echoHyphenatedWord($word, $patternData);

            echo $time->getRunningDuration();
            $cache->set($word, $hyphenateTheWord->echoHyphenatedWord($word, $patternData));
            $log->log("\nWord to hyphenate: " . $word, "Hyphenated word: " . $hyphenateTheWord->echoHyphenatedWord($word, $patternData));
            $log->logTime($time->getRunningDuration());
        }
    }

    protected function insertWordsToDb()
    {
        $database = App::get('database');
        $words = $this->fileToArray('resources/words.txt');

        $database->insert('words_table', 'word', $words);
    }

    protected function insertPatternToDb()
    {
        $database = App::get('database');
        $patternData = $this->fileToArray('resources/pattern_data.txt');

        $database->insert('pattern_table', 'pattern', $patternData);
    }

    protected function file()
    {
        $time = new Timer();
        $cache = new Cache('cache.txt');
        $words = $this->fileToArray('resources/words.txt');

        foreach ($words as $word) {
            if ($cache->get($word)) {
                echo $cache->get($word) . "\r\n";
            }
        }
        echo $time->getRunningDuration();
    }

    protected function fileToArray($location)
    {
        return explode("\n", file_get_contents($location));
    }
}