<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.10
 * Time: 13.52
 */

namespace Classes\Side_Functions\Database;


class DatabaseQ
{

    public function getPatternData($patternArr)
    {
        $patternArray = [];

        foreach ($patternArr as $row) {

            $patternArray[] = $row['pattern'];

        }
        return $patternArray;
    }

    public function getWordsData($wordsArr)
    {
        $wordsArray = [];

        foreach ($wordsArr as $row) {

            $wordsArray[] = $row['word'];

        }
        return $wordsArray;
    }

    public function getHyphenatedWordsData($hyphenatedWords)
    {
        $hyphenatedWordsArray = [];

        foreach ($hyphenatedWords as $row) {

            $hyphenatedWordsArray[] = $row['hyphenated_word'];

        }
        return $hyphenatedWordsArray;
    }
}