<?php

$config = [
    'env' => 'dev',
    'cachePath' => __DIR__ . '/cache',
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=taskboard',
        'user' => 'root',
        'password' => '',
    ],
    'viewData' => [
        'href' => '//noteboard.loc',
        'static_arg' => '?' . time(),
    ],
];

return $config;