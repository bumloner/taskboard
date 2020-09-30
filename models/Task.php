<?php

class Task
{
    public $id;
    public $username;
    public $email;
    public $text;
    public $status = true;
    public $is_edited = false;

    public function saveNew()
    {
        $task = R::dispense('task');
        $task->username = $this->username;
        $task->email = $this->email;
        $task->text = $this->text;
        $task->status = $this->status;
        $task->is_edited = $this->is_edited;
        $this->id = R::store($task);
    }

}
