<?php

return [

    'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'connection' => 'mysql:host=' . getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ],
        'prefix' => ''
    ],
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => __DIR__ . '/database/' . getenv('DB_NAME'),
        'prefix' => '',
    ]
]

];

