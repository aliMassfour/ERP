<?php
namespace App\Notification;

use App\Models\Task;
use App\Models\User;

interface Notification{
    public function notificate(User $user,Task $task);
    
}