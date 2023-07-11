<?php
namespace App\Notification;

use App\Models\Task;
use App\Models\User;

class TaskNotification implements Notification{
    public function notificate(User $user,  Task $task)
    {
       $user =  $user->notifications()->create([
            'subject' => 'your manager give you new task with object: ' . $task->description
        ]);
    }

}