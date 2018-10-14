<?php

use App\App;
use App\Database\Connection;
use App\Database\QueryBuilder;
require __DIR__.'/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__. '/..');
$dotenv->load();

App::bind('config', $config = require 'config.php');

App::bind('database', new QueryBuilder(
    Connection::make($config['connections'][getenv('DB_DRIVER')])
));