<?php

$config = [
    'env' => 'dev',
    'viewData' => [
        'href' => '//taskboard.loc',
    ],
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=taskboard',
        'user' => 'root',
        'password' => '',
    ],
    'cachePath' => __DIR__ . '/cache',
];

return $config;
