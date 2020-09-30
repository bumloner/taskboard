<?php

function index_route()
{
    $task = new Task();
    $task->setUsername('Ivan');
    echo $task->getUsername();



    return Html::render('index');
}
