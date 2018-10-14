<?php

namespace App;

use App\Traits\Actions;

class App
{
    protected static $registry = [];
    use Actions;

    public static function bind($key, $value)
    {

        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new \Exception ("No {$key} is bound in the container");
        }
        return static::$registry[$key];
    }

    public function runApp($argv)
    {
        switch ($argv[1]) {
            case 0:
                $this->file();
                break;
            case "insertPatternDataToDb":
                $this->insertPatternToDb();
                break;
            case "insertWordsDataToDb":
                $this->insertWordsToDb();
                break;
            case 3:
                $this->word($argv[2]);
                break;
            case 4:
                $this->dbWord($argv[2]);
                break;
        }
    }
}