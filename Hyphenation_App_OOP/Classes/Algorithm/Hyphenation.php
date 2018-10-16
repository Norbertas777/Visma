<?php

namespace Classes\Algorithm;

class Hyphenation extends PatternDataToArray
{

    private $patternWithLettersOnly;
    private $wordToHyphenate;
    private $wordToHyphenateDots;

    protected function setPatternToLettersOnly($pattern)
    {
        $this->patternWithLettersOnly = preg_replace('/[^A-Za-z.]/', '', $pattern);
    }

    protected function getPatternToLettersOnly()
    {
        return $this->patternWithLettersOnly;
    }


    public function setWordToHyphenate()
    {
        $wordEntered[] = readline("Enter your word to hyphenate:");

        $this->wordToHyphenate = implode("", $wordEntered);
    }

    public function getWordToHyphenate()
    {
        return $this->wordToHyphenate;
    }


    protected function getHyphenatedWord($wordNumArr, $wordToAnalyze)
    {
        $str = '';
        $word_key = 1;

        for ($i = 1; $i < count($wordNumArr) - 1; $i++) {

            $str .= $wordToAnalyze[$word_key];

            if ($wordNumArr[$i] & 1) {

                $str .= '-';
            }
            $word_key++;
        }
        return $str;
    }

    public function echoHyphenatedWord($wordToHyphenate, $patternArr)
    {
        $wordToAnalyze = $this->prepareWordForAnalyze($wordToHyphenate);
        $wordNumArray = $this->parseWordNums($wordToAnalyze, $patternArr);

        return $this->getHyphenatedWord($wordNumArray, $wordToAnalyze);
    }

    protected function parseWordNums($wordToAnalyze, $patternArr)
    {
        $wordLength = strlen($wordToAnalyze);
        $wordNumArr = array_fill(0, $wordLength, null);

        foreach ($patternArr as $pattern) {

            $plainPattern = preg_replace('/[^A-Za-z.]/', '', $pattern);
            $patternBeginPos = strpos($wordToAnalyze, $plainPattern);

            if ($patternBeginPos === false) {
                continue;
            } else {

                $patternKey = 0;

                for ($i = 0; $i < strlen($pattern); $i++) {

                    if (!is_numeric($pattern[$i])) {
                        $patternKey++;
                    } else {
                        $key = $patternBeginPos + $patternKey - 1;

                        if ($wordNumArr[$key] === null) {
                            $wordNumArr[$key] = (int)$pattern[$i];
                        } else {
                            $wordNumArr[$key] = (int)$pattern[$i] > (int)$wordNumArr[$key]
                                ? (int)$pattern[$i]
                                : (int)$wordNumArr[$key];
                        }
                    }
                }
            }
        }


        return $wordNumArr;
    }


    protected function prepareWordForAnalyze($wordToHyphenate)
    {
        $this->wordToHyphenateDots = '.' . $wordToHyphenate . '.';

        return $this->wordToHyphenateDots;
    }

    public function echoManyHyphenatedWords($wordNumArr, $patternArr)
    {
        foreach ($wordNumArr as $word) {

            return $this->echoHyphenatedWord($word, $patternArr) . "\n";
        }
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

