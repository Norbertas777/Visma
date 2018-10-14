<?php

namespace App\Algorithm;

class Hyphenation
{
    public function getHyphenatedWord($word_num_arr, $word_to_analyze)
    {
        $str = '';
        $word_key = 1;

        foreach ($word_num_arr as $iValue) {
            $str .= $word_to_analyze[$word_key];
            if ($iValue & 1) {
                $str .= '-';
            }
            $word_key++;
        }
        return $str;
    }

    public function echoHyphenatedWord($wordToHyphenate, $pattern_arr)
    {
        $word_to_analyze = $this->prepareWordForAnalyze($wordToHyphenate);
        $word_num_arrr = $this->parseWordNums($word_to_analyze, $pattern_arr);

        return $this->getHyphenatedWord($word_num_arrr, $word_to_analyze);
    }

    public function parseWordNums($word_to_analyze, $pattern_arr)
    {
        $word_length = strlen($word_to_analyze);
        $word_num_arr = array_fill(0, $word_length, null);

        foreach ($pattern_arr as $pattern) {

            $plain_pattern = preg_replace('/[^A-Za-z.]/', '', $pattern);
            $pattern_begin_pos = strpos($word_to_analyze, $plain_pattern);

            if ($pattern_begin_pos === false) {
                continue;
            }
            $pattern_key = 0;

            foreach ($pattern as $i => $iValue) {

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

        return $word_num_arr;
    }


    public function prepareWordForAnalyze($wordToHyphenate)
    {
        return '.' . $wordToHyphenate . '.';
    }

    public function getPatternMatches($enteredWord, $wordFragments)
    {

        $wordWithDots = '.' . $enteredWord . '.';
        $matchesArr = array_fill(0, strlen($enteredWord) + 1, null);
        foreach ($wordFragments as $fragment) {
            $position = strpos($wordWithDots, preg_replace("/[0-9]/", "", $fragment));
            if ($position >= 0 && $position !== false) {
                $matchesArr[$position] = $fragment;
            }
        }
        return $matchesArr;
    }

}

