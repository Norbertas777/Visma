<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{

    public static function make($config)
    {
        return $config['driver'];
        try {
            if($config['driver'] === 'sqlite'){
                return new PDO(
                    'sqlite:' .__DIR__.'/../../database/local.sqlite'
                );
            }
            return new PDO(
                $config['connection'] . ";dbname" . $config['database'],
                $config['user'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
