<?php

namespace App\Algorithm;

class PatternDataToArray
{
    public $patternArray;
    public $wordsToTestArray;


    public function setPatternFileLocation($location)
    {
        $this->patternArray = explode("\n", file_get_contents($location));
    }

    public function setWordsToTestFileLocation($location)
    {
        $this->wordsToTestArray = explode("\n", file_get_contents($location));
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

