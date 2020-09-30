<?php

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


class Router
{
    public $route;
    public $fileName;

    function __construct()
    {
        $route_name = $this->get();
        if ($this->exists($route_name)) {
            $this->route = $route_name;
            $this->fileName = __DIR__ . '/routes/' . $this->route . '.php';
        }
    }

    private function get()
    {
        if (!isset($_GET['p']) || $_GET['p'] === '' || $_GET['p'] === '/') {
            return 'index';
        }
        return $_GET['p'];
    }

    public function run()
    {
        if (!$this->fileName || !require($this->fileName)) {
            Router::errorNotFound();
        }

        $route_class = ucfirst($this->route) . 'Route';
        if (!class_exists($route_class)) {
            Router::errorNotFound();
        }

        try {
            exit(call_user_func($route_class . '::run'));
        } catch (Exception $e) {
            Router::errorNotFound();
        }
    }

    private function exists($route_name)
    {
        $found = false;

        if ($handle = opendir(__DIR__ . '/routes')) {
            while (($file = readdir($handle)) !== false) {
                if (is_file($file)) {
                    $route = basename($file, '.php');
                    if ($route === $route_name) {
                        $found = true;
                        break;
                    }
                }
            }
            closedir($handle);
        }
        return $found;
    }

    public static function errorNotFound()
    {
        exit(Html::render('404'));
    }
}
