<?php

namespace App;

use Psr\Log\AbstractLogger;


class Logger extends AbstractLogger
{

    private $log;

    public function __construct()
    {
        $this->log = fopen('log.txt', 'a');
    }

    public function __destruct()
    {
        fclose($this->log);
    }

    public function log($level, $message, array $context = array())
    {
        fwrite($this->log, "$level \n");
        fwrite($this->log, "$message");
    }

    public function setLog($time, $myword)
    {
        fwrite($this->log, $time);
        fwrite($this->log, "$myword");
    }

    public function logTime($time)
    {
        fwrite($this->log, $time);
    }
}
