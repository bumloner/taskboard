<?php

function index_route()
{
    define('TASKS_NUMBER', 3);

    // pagination
    $pagination = [];
    if (isset($_GET['page'])) {
        $pagination['current'] = (int) $_GET['page'];
    } else {
        $pagination['current'] = 1;
    }
    $pagination['total'] = ceil((R::count('task') / 3)) || 1;

    // sort
    $sort_titles = [
        'no' => 'ID',
        'username_asc' => 'Username ASC',
        'username_desc' => 'Username DESC',
        'email_asc' => 'Email ASC',
        'email_desc' => 'Email DESC',
        'status_asc' => 'Status ASC',
        'status_desc' => 'Status DESC',
    ];
    $sort_sql = [
        'no' => '',
        'username_asc' => ' ORDER BY username ASC',
        'username_desc' => ' ORDER BY username DESC',
        'email_asc' => ' ORDER BY email ASC',
        'email_desc' => ' ORDER BY email DESC',
        'status_asc' => ' ORDER BY status ASC',
        'status_desc' => ' ORDER BY status DESC',
    ];

    $sort = [];
    if (isset($_GET['sort']) && array_key_exists($_GET['sort'], $sort_titles)) {
        $sort['type'] = $_GET['sort'];
    } else {
        $sort['type'] = 'no';
    }
    $sort['title'] = $sort_titles[$sort['type']];

    // current page must exists
    if (1 <= $pagination['current'] && $pagination['current'] <= $pagination['total']) {
        $sql = $sort_sql[$sort['type']];
        $sql .= limit_by_page($pagination['current']);
        $tasks = R::find('task', $sql);
    } else {
        $tasks = [];
    }

    return Html::render('index', compact('tasks', 'pagination', 'sort', 'sort_titles'));
}

function limit_by_page($page)
{
    return ' LIMIT ' . (($page - 1) * 3) . ',3';
}
