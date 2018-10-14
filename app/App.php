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

    public function runApp($toDo)
    {
        switch ($toDo) {

            case "file":
                $this->file();
                break;
            case "insertPatternDataToDb":
                $this->insertPatternToDb();
                break;
            case "insertWordsDataToDb":
                $this->insertWordsToDb();
                break;
            case "word":
                $this->word();
                break;
            case "dbWord":
                $this->dbWord();
                break;
        }
    }

}