<?php

namespace App;


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
}
