<?php

class Task
{
    public $bean;

    public function create()
    {
        $this->bean = R::dispense('task');
    }

    public function save()
    {
        return R::store($this->bean);
    }

    public function load($id)
    {
        $this->bean = R::load( 'task', $id);
        if ((int) $this->bean->id !== $id) {
            return false;
        }
        return true;
    }
}
