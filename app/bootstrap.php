<?php


use App\App;
use App\Database\Connection;
use App\Database\QueryBuilder;

App::bind('config', $config = require 'config.php');


App::bind('database', new QueryBuilder(
    Connection::make($config['connections']['sqlite'])
));