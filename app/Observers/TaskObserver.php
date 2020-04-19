<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    public function retrieved(Task $task)
    {
        if ($task->estimateAt) {
            $task->estimateAt = date_create($task->estimateAt);
            $task->estimateAt = $task->estimateAt->format('Y-m-d\TH:i:s');
        }

    }
}