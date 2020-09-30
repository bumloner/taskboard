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

        // "static_arg" forcing update cache of static files
        $data['config'] = App::$config['viewData'];
        $data['config']['static_arg'] = ((App::$config['env'] === 'dev') ? '?' . time() : '');

        $data['msg'] = Router::getMsg();
        $data['is_logged'] = is_logged();

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

function is_logged()
{
    return (isset($_SESSION['is_logged']) && $_SESSION['is_logged']);
}
