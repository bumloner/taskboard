<?php

// connect to db
$ret = R::setup($config['db']['dsn'], $config['db']['user'], $config['db']['password']);

if (!R::testConnection()) {
    exit('Database connection error.');
}

echo 'Hello world! ';
