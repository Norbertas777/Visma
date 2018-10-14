<?php

namespace App;


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