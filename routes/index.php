<?php

function index_route()
{
    define('TASKS_NUMBER', 3);

    $pagination = [];

    if (isset($_GET['page'])) {
        $pagination['current'] = (int) $_GET['page'];
    } else {
        $pagination['current'] = 1;
    }

    $pagination['total'] = ceil((R::count('task') / 3));

    // current page must exists
    if (1 <= $pagination['current'] && $pagination['current'] <= $pagination['total']) {
        $tasks = R::find('task', ' LIMIT ' . (($pagination['current'] - 1) * 3) . ',3');
    } else {
        $tasks = [];
    }

    return Html::render('index', compact('tasks', 'pagination'));
}
