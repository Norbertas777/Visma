<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.3
 * Time: 15.19
 */

namespace Classes\Algorithm;

class PatternDataToArray
{
    protected $patternArray;
    protected $wordsToTestArray;

    public function __construct()
    {
        $this->patternArray = explode("\n", file_get_contents('Resources/pattern_data.txt'));
        $this->wordsToTestArray = explode("\n", file_get_contents('Resources/words.txt'));
    }

    public function getPatternData()
    {
        return $this->patternArray;
    }

    public function getWordsToTestData()
    {
        return $this->wordsToTestArray;
    }
}

