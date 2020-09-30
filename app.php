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
        $ret = R::setup(App::$config['db']['dsn'], App::$config['db']['user'], App::$config['db']['password']);

        if (!R::testConnection()) {
            exit('Database connection error.');
        }

        $router = new Router();
        $router->run();
    }
}
