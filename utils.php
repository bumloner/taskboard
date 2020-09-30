<?php

class Html
{
    public static function render($view_name, $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => App::$config['cachePath'] . '/twig',
            'debug' => (App::$config['env'] === 'dev'),
        ]);

        $data['config'] = App::$config['viewData'];

        return $twig->render($view_name . '.html', $data);
    }

    public static function encode($content)
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function decode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }
}