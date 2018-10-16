<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.16
 * Time: 10.42
 */

namespace Classes\Algorithm;


class PatternDataProxy
{
   public $patternDataToArray = NULL;
   public $patternArray = NULL;
   public $wordsToTestArray = NULL;


   public function __construct()
   {
       $this->patternArray = explode("\n", file_get_contents('Resources/pattern_data.txt'));
       $this->wordsToTestArray = explode("\n", file_get_contents('Resources/words.txt'));
   }



    public function getPatternData()
    {
        if($this->patternArray == NULL){
            $this->makePatternDataToArray();
        }
        return $this->patternArray;
    }

    public function getWordsToTestData()
    {
        if($this->wordsToTestArray == NULL){
            $this->makeWordsDataToArray();
        }
        return $this->wordsToTestArray;
    }


    public function makePatternDataToArray()
   {
       $this->patternDataToArray = new PatternDataToArray()-$this->getPatternData();
   }

    public function makeWordsDataToArray()
    {
        $this->patternDataToArray = new PatternDataToArray()-$this->getWordsToTestData();
    }

}