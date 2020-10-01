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
        $id = (int) $_POST['id'];
        $task = new Task();
        if (!$task->load($id)) {
            return Router::redirect('edit_task', [
                'msg' => 'Task doesn\'t exists',
                'id' => $id
            ]);
        }

        $new_text = (string) $_POST['text'];
        if ($new_text !== $task->bean->text) {
            $task->bean->is_edited = true;
        }
        $task->bean->text = $new_text;
        $task->bean->status = (bool) $_POST['status'];
        $task->save();

        return Router::redirect('edit_task', [
            'msg' => 'Task edited! (# ' . $task->bean->id . ')',
            'id' => $id
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
