<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.7
 * Time: 16.59
 */

namespace Hyphenation_App_OOP\Classes\Side_Functions;


class Timer
{
    private $startTime;

    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    public function getRunningDuration()
    {
        $timeEnd = microtime(true);
        $duration = $timeEnd - $this->startTime;
        return "\nExecuted in " . $duration . " seconds." . "\n";
    }

    public function printRunningDuration()
    {
        echo $this->getRunningDuration();
    }
}
