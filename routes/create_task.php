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
        $task->create();
        $task->bean->username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $task->bean->email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $task->bean->text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
        $task->save();

        return Router::redirect('/', [
            'msg' => 'Task created! (# ' . $task->bean->id . ')'
        ]);
    }

    return Html::render('create_task');
}
