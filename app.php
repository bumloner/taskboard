<?php

require __DIR__ . '/models/Task.php';
require __DIR__ . '/router.php';
require __DIR__ . '/utils.php';

class App
{
    public static $config;

    public static function run()
    {
        // connect to db
        R::setup(App::$config['db']['dsn'], App::$config['db']['user'], App::$config['db']['password']);

        if (!R::testConnection()) {
            exit('Database connection error.');
        }

        if (self::$config['env'] === 'dev') {
            R::freeze(true); // freeze from automatic changing structures in db
        }

        session_start();

        $router = new Router();
        $router->run();
    }
}
