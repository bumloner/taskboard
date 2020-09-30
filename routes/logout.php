<?php

function logout_route()
{
    if (!is_logged()) {
        return Router::redirect('login');
    }

    session_unset();
    session_destroy();

    return Router::redirect('/', [
        'msg' => 'You are logged out'
    ]);
}
