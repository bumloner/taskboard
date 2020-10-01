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
        $task->bean->username = (string) $_POST['username'];
        $task->bean->email = (string) $_POST['email'];
        $task->bean->text = (string) $_POST['text'];
        $task->bean->status = false;
        $task->bean->is_edited = false;
        $task->save();

        return Router::redirect('/', [
            'msg' => 'Task created! (# ' . $task->bean->id . ')'
        ]);
    }

    return render('create_task');
}
