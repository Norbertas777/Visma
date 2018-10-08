<?php

$start_timer = microtime(true);

$word_to_analyze = implode('',array($argv[1]));
$patterns_arr = explode("\n", file_get_contents('pattern_data.txt'));

$patternsWord_arr = explode("\n", file_get_contents('words.txt'));

echo parseWord($word_to_analyze, $patterns_arr)."\n";

foreach ($patternsWord_arr as $pattern) {
    echo parseWord($pattern, $patterns_arr) . "\n";
}

$time_elapsed_secs = microtime(true) - $start_timer;

echo "App run time: " . $time_elapsed_secs;

function parseWord($word_to_analyze, $pattern_arr)
{
    $word_to_analyze = prepareWordForAnalyze($word_to_analyze);
    $word_num_arr = parseWordNums($word_to_analyze, $pattern_arr);

    return getParsedWord($word_num_arr, $word_to_analyze);
}

function patternToLettersOnly($pattern)
{
    $patternWithLettersOnly = preg_replace('/[^A-Za-z.]/', '', $pattern);

    return $patternWithLettersOnly;
}

function parseWordNums($word_to_analyze, $pattern_arr)
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

function getParsedWord($word_num_arr, $word_to_analyze)
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

function prepareWordForAnalyze($word_to_analyze)
{
    return '.' . $word_to_analyze . '.';
}