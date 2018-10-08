<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.8
 * Time: 12.45
 */

namespace Hyphenation_App_OOP\Classes\Side_Functions;

class Database
{

    public $pdo;


    public function __construct()
    {

        $host = '127.0.0.1';
        $db = 'hyphenation';
        $user = 'root';
        $pass = 'password';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


    public function uploadPatterns($location)
    {
        $patterns = explode("\n", file_get_contents($location));

        foreach ($patterns as $patternToInsert) {

            $query = $this->pdo->prepare("INSERT INTO pattern_table (pattern) VALUE (:pattern)");

            $query->bindParam(':pattern', $patternToInsert);

            $query->execute();

        }

    }

        public function uploadWords($location)
    {
        $words = explode("\n", file_get_contents($location));

        foreach ($words as $wordToInsert) {

            $query = $this->pdo->prepare("INSERT INTO words_table (word) VALUE (:word)");

            $query->bindParam(':word', $wordToInsert);

            $query->execute();

        }

    }
}