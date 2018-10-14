<?php

return [
    'connections' => [
        'mysql'=>[
            'driver'=> 'mysql',
            'connection' => 'mysql:host=localhost',
            'database' => 'hyphenation',
            'user' => 'root',
            'password' => 'password',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            ],
            'prefix' => ''
        ] ,
        'sqlite'=>[
            'driver'=> 'sqlite',
            'database' => __DIR__ . '/database/local.sqlite',
            'prefix' => '',
        ]
    ]

];

