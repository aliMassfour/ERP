<?php

namespace App\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RejectNotification implements Notification
{
    private $message;
    public function __construct($message)
    {
        $this->message = $message;
    }
    public function notificate(User $user, Model $task)
    {
        $user->notifications()->create([
            'subject' => 'your manager rejected the task with id ' . $task->id . ' because ' . $this->message
        ]);
    }
}
