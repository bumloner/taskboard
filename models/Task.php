<?php

class Task
{
    private $username;
    private $email;
    private $text;
    private $status;
    private $is_edited;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
