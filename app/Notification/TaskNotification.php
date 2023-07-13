<?php
namespace App\Notification;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TaskNotification implements Notification{
    public function notificate(User $user,Model $task)
    {
       $user =  $user->notifications()->create([
            'subject' => 'your manager give you new task with object: ' . $task->description
        ]);
    }

}