<?php
namespace App\Notification;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface Notification{
    public function notificate(User $user,Model $task);
    
}