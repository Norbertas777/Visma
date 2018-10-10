<?php

use Classes\Side_Functions\Database;
use Classes\Side_Functions\DatabaseQ;
use Classes\Side_Functions\Timer;
use Classes\Side_Functions\Cache;
use Classes\Side_Functions\Logger;
use Classes\Algorithm\PatternDataToArray;
use Classes\Algorithm\Hyphenation;

spl_autoload_register(function ($class) {

    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (file_exists($file)) {

        require $file;

        return true;
    }
    return false;
});


switch ($argv[1]) {

    case "-file":

        $time = new Timer();
        $cache = new Cache('Cache.txt');
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();
        $hyphenateManyWords = new Hyphenation();

        $wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
        $wordToTestList->getWordsToTestData();

        foreach ($wordToTestList->getWordsToTestData() as $wor) {
            if ($cache->get($wor) !== false) {
                echo $cache->get($wor) . "\r\n";
            } else {

                $patternList->setPatternFileLocation('Resources/pattern_data.txt');
                $patternList->getPatternData();
                $wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
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
        break;

    case "-insertPatternDataToDb":

        $connection = new Database();
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();

        $patternList->setPatternFileLocation('Resources/pattern_data.txt');
        $patternList->getPatternData();
        $wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
        $wordToTestList->getWordsToTestData();

        $connection->insert('pattern_table','pattern',$patternList->getPatternData());

        break;

    case "-insertWordsDataToDb":

        $connection = new Database();
        $patternList = new PatternDataToArray();
        $wordToTestList = new PatternDataToArray();

        $patternList->setPatternFileLocation('Resources/pattern_data.txt');
        $patternList->getPatternData();
        $wordToTestList->setWordsToTestFileLocation('Resources/words.txt');
        $wordToTestList->getWordsToTestData();

        $connection->insert('words_table','word', $wordToTestList->getWordsToTestData());

        break;

    case "-word":

        $time = new Timer();
        $cache = new Cache('Cache.txt');
        $log = new Logger();
        $patternList = new PatternDataToArray();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();

        if ($cache->get($wordToHyphen->getWordToHyphenate()) !== false) {
            echo $cache->get($wordToHyphen->getWordToHyphenate()) . "\r\n";

        } else {

            $patternList->setPatternFileLocation('Resources/pattern_data.txt');
            $patternList->getPatternData();

            $wordToHyphen->setWordToHyphenate();
            $wordToHyphen->getWordToHyphenate();

            echo $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData());

            $time->printRunningDuration();

            $cache->set($wordToHyphen->getWordToHyphenate(), $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));

            $log->log("\nWord to hyphenate: " . $wordToHyphen->getWordToHyphenate(), "Hyphenated word: " . $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternList->getPatternData()));
            $log->logTime($time->getRunningDuration());

        }

        break;

    case "-dbWord":

        $connection = new Database();
        $query = new DatabaseQ();
        $wordToHyphen = new Hyphenation();
        $hyphenateTheWord = new Hyphenation();

        $wordToHyphen->setWordToHyphenate();
        $wordToHyphen->getWordToHyphenate();
        $patternArrDB = $connection->select('*','pattern_table');
        $patternArr = $query->getPatternData($patternArrDB);
        $wordsArrDB = $connection->select('*','words_table');
        $wordsArr = $query->getWordsData($wordsArrDB);
        $hyphenatedArrDB = $connection->select('*','hyphenated_words_table');
        $hyphenatedArr = $query->getHyphenatedWordsData($hyphenatedArrDB);
      

        $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($wordToHyphen->getWordToHyphenate(), $patternArr);
        $checkIfExist = $connection->selectWhere('*','hyphenated_words_table','hyphenated_word',$wordToInsert);



         if(empty($checkIfExist))  {

              $connection->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);
              echo "Hyphenated word inserted with success! \n";

            }  else {

              echo "Word: " . $wordToHyphen->getWordToHyphenate() . " was already hyphenated and inserted to database!";
            }

//        $connection->select('hyphenated_word','hyphenated_words_table');
//        $connection->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);

//        foreach($wordsArr as $word) {
//
//            $wordToInsert = $hyphenateTheWord->echoHyphenatedWord($word, $patternArr);
//            $connection->insert('hyphenated_words_table', 'hyphenated_word', $wordToInsert);        // insert many words
//        }

          echo  "\n".$wordToInsert."\n";

         $matches=$hyphenateTheWord->getPatternMatches($wordToHyphen->getWordToHyphenate() ,$patternArr);

         echo "Patterns that match the word entered: " . implode(" ",$matches);
        break;
}

