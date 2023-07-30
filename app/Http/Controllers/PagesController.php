<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return redirect('/login');
    }

    public function dashboard()
    {
        $users = User::all();
        $max = 0;
        $month_user = null;
        foreach ($users as $user) {
            $tasks = $user->tasks()->whereMonth('created_at', now()->month)
                ->where('accept', '1')
                ->get();

            if (sizeof($tasks) > $max && sizeof($tasks) > 0) {
                $max = sizeof($tasks);
                $month_user = $user;
            }
        }
        return view('dashboard')->with('user', $month_user);
    }
}
