<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 10.08
 */

class PatternMatches
{


    public function getPatternMatches($enteredWord, $patternArray)
    {

        $wordWithDots = '.' . $enteredWord . '.';
        $matchesArr = array_fill(0, strlen($enteredWord) + 1, null);

        foreach ($patternArray as $fragment) {
            $position = strpos($wordWithDots, preg_replace("/[0-9]/", "", $fragment));
            if ($position >= 0 && $position !== false) {
                $matchesArr[$position] = $fragment;
            }
        }
        return $matchesArr;
    }



}