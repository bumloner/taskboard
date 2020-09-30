<?php

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
        if (!is_file($this->fileName) || !require($this->fileName)) {
            exit(Router::errorNotFound());
        }

        exit(call_user_func($this->route . '_route'));
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
        return Html::render('404');
    }
}
