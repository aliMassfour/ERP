<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function UnreadNotification()
    {
        $notifications = auth()->user()->notifications()->where('status','unread')->get();
        foreach($notifications as$notification){
            $notification->status='read';
            $notification->save();
        }
        return view('components.notification.notification')->with('notifications',$notifications);
    }
}
