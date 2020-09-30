<?php

function login_route()
{
    if (is_logged()) {
        return Router::redirect('/');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $admin = [
            'username' => 'admin',
            'password' => '123',
        ];

        // check and validate params
        if (!Router::existsPostParams(['username', 'password'])) {
            return Router::redirect('login', [
                'msg' => 'Error: Missing params'
            ]);
        }

        // login
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        if ($username !== $admin['username'] || $password !== $admin['password']) {
            return Router::redirect('login', [
                'msg' => 'Error: Invalid login or password'
            ]);
        }

        $_SESSION['is_logged'] = true;

        return Router::redirect('/', [
            'msg' => 'You are successfully logged as ' . $username . '!'
        ]);
    }

    return Html::render('login');
}
