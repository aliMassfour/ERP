<?php
namespace App\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReportNotification implements Notification{
        public function notificate(User $user,Model $task){
            $user->notifications()->create([
                'subject' => 'there is an new task report from employee'.$task->user->name
            ]);
        }
}