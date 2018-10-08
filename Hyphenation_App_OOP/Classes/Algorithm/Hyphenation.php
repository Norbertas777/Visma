<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.7
 * Time: 16.10
 */
//
//
namespace Hyphenation_App_OOP\Classes\Algorithm;

class Hyphenation extends PatternDataToArray
{

    public $patternWithLettersOnly;
    public $wordToHyphenate;
    public $wordToHyphenateDots;



    public function setPatternToLettersOnly($pattern)
    {

        $this->patternWithLettersOnly = preg_replace('/[^A-Za-z.]/', '', $pattern);


    }

    public function getPatternToLettersOnly()
    {

        return $this->patternWithLettersOnly;


    }

    public function setWordToHyphenate()
    {

        $wordEntered[] = readline("Enter your word to hyphenate:");

        $this->wordToHyphenate = $wordEntered;


    }

    public function getWordToHyphenate()
    {

        return $this->wordToHyphenate;


    }



    public function getParsedWord($word_num_arr, $word_to_analyze)
    {
        $str = '';
        $word_key = 1;

        for ($i = 1; $i < count($word_num_arr) - 1; $i++) {

            $str .= $word_to_analyze[$word_key];

            if ($word_num_arr[$i] & 1) {
                $str .= '-';
            }

            $word_key++;
        }

        return $str;
    }

    public function parseWord($wordToHyphenate, $pattern_arr)
    {
        $word_to_analyze = prepareWordForAnalyze($wordToHyphenate);
        $word_num_arr = parseWordNums($word_to_analyze, $pattern_arr);

        return getParsedWord($word_num_arr, $word_to_analyze);
    }

    public function parseWordNums($word_to_analyze, $pattern_arr)
    {

        $word_length = strlen($word_to_analyze);
        $word_num_arr = array_fill(0, $word_length, null);

        foreach ($pattern_arr as $pattern) {
            $plain_pattern = patternToLettersOnly($pattern);

            $pattern_begin_pos = strpos($word_to_analyze, $plain_pattern);

            if ($pattern_begin_pos === false) {
                continue;
            } else {
                $pattern_key = 0;
                for ($i = 0; $i < strlen($pattern); $i++) {

                    if (!is_numeric($pattern[$i])) {
                        $pattern_key++;
                    } else {
                        $key = $pattern_begin_pos + $pattern_key - 1;

                        if ($word_num_arr[$key] === null) {
                            $word_num_arr[$key] = (int)$pattern[$i];
                        } else {
                            $word_num_arr[$key] = (int)$pattern[$i] > (int)$word_num_arr[$key]
                                ? (int)$pattern[$i]
                                : (int)$word_num_arr[$key];
                        }
                    }
                }
            }
        }

        return $word_num_arr;
    }

//    public function addDotsToWord($wordToHyphenate)
//    {
//
//        $this->wordToHyphenateDots = '.' . $wordToHyphenate . '.';
//
//        return $this->wordToHyphenateDots;
//    }

   public function prepareWordForAnalyze($wordToHyphenate)
    {
        $this->wordToHyphenateDots ='.' . $wordToHyphenate . '.';
        return $this->wordToHyphenateDots;
    }
 }