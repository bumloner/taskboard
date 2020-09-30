<?php

function create_task_route()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // check and validate params
        if (!Router::existsPostParams(['username', 'email', 'text'])) {
            return Router::redirect('create_task', [
                'msg' => 'Error: Missing params'
            ]);
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return Router::redirect('create_task', [
                'msg' => 'Error: Invalid email'
            ]);
        }

        // create task
        $task = new Task();
        $task->username = $_POST['username'];
        $task->email = $_POST['email'];
        $task->text = $_POST['text'];
        $task->saveNew();

        return Router::redirect('/', [
            'msg' => 'Task created! (# ' . $task->id . ')'
        ]);
    }

    return Html::render('create_task');
}
