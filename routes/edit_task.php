<?php

function edit_task_route()
{
    if (!is_logged()) {
        return Router::redirect('/', [
            'msg' => 'You cannot edit tasks'
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // check and validate params
        if (!Router::existsPostParams(['id', 'text'])) {
            return Router::redirect('edit_task', [
                'msg' => 'Error: Missing params',
                'id' => (isset($_POST['id']) ? $_POST['id'] : 0)
            ]);
        }

        // edit task
        $task = new Task();
        if (!$task->load((int) $_POST['id'])) {
            return Router::redirect('edit_task', [
                'msg' => 'Task doesn\'t exists',
                'id' => $_POST['id']
            ]);
        }

        $new_text = (string) filter_var($_POST['text'], FILTER_SANITIZE_STRING);
        if ($new_text !== $task->bean->text) {
            $task->bean->is_edited = true;
        }
        $task->bean->text = $new_text;
        $task->bean->status = (bool) $_POST['status'];
        $task->save();

        return Router::redirect('edit_task', [
            'msg' => 'Task edited! (# ' . $task->bean->id . ')',
            'id' => $_POST['id']
        ]);
    }

    $task = new Task();
    if (!isset($_GET['id']) || !$task->load((int) $_GET['id'])) {
        return Router::errorNotFound();
    }

    return render('edit_task', [
        'task' => $task->bean
    ]);
}
