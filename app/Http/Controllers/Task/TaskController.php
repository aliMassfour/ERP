<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Notification\RejectNotification;
use App\Notification\TaskNotification;
use App\Upload\FileUpload;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $task_notificate;
    public function __construct()
    {
        $this->task_notificate = new TaskNotification();
    }
    // must delete
    public function index(User $user)
    {
        $tasks = $user->tasks()->where('deadline', '>', now())->get();
        return view('components.tasks.index')->with('tasks', $tasks);
    }
    public function create()
    {
        return view('components.tasks.create_task');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'user_id' => 'required'
        ]);

        try {
            $user = User::find($request->user_id);
            $task = Task::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $user->id,
                'deadline' => $request->deadline,
                'state' => 'progress'
            ]);
            $this->task_notificate->notificate($user, $task);
            return redirect()->route('dashboard')->withStatus('__create the task success');
        } catch (Exception $e) {
            echo $e;
            // return redirect()->back()->withStatus('__error ocurred please try again');
        }
    }
    public function UserTaskList()
    {
        $user = auth()->user();
        $tasks = $user->tasks()->whereMonth('created_at', '=', now()->month)->get();
        $filter_tasks = [];
        $tasks->filter(function ($task) use (&$filter_tasks) {
            if ($task->accept == '0') {
                $task->setAttribute('status', 'rejected');
            } elseif ($task->state == 'progress') {
                $task->setAttribute('status', 'pending');
            } elseif ($task->accept == '1') {
                $task->setAttribute('status', 'accepted');
            } elseif ($task->dedline > now()) {
                $task->setAttribute('status', 'expired');
            } elseif ($task->state == 'accomplished' && $task->accept == null) {
                $task->setAttribute('status', 'accomplished');
            }
            $task->makeHidden(['user', 'report', 'evaluation', 'created_at', 'updated_at', 'state', 'user_id']);
            $task->setAttribute('user_name', $task->user->name);
            $filter_tasks[] = $task;
        });
        return view('components.tasks.view_tasks')->with('tasks', $tasks);
    }
    public function accept(Request $request, Task $task)
    {
        // $this->validate($request, [
        //     'rating' => 'required'
        // ]);
        if ($request->has('rating')) {
            $task->evaluation = $request->rating;
        } else {
            $task->evaluation = 0;
        }
        $task->accept = '1';
        if ($task->save()) {
            return redirect()->back()->withStatus('accept the task success');
        } else {
            return redirect()->back()->withStatus('error ocurred please try again');
        }
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('dashboard')->withStatus('delete the task success');
    }
    public function reject(Task $task, Request $request)
    {
        $task->accept = '0';
        $task->evaluation = 0;

        if ($task->save()) {
            $this->task_notificate = new RejectNotification($request->message);
            $this->task_notificate->notificate($task->user, $task);
            return redirect()->back()->withStatus('task rejected');
        }
    }
    public function view()
    {
        $tasks = Task::whereMonth('created_at', '=  ', now()->month)->get();
        $filter_tasks = [];
        $tasks->filter(function ($task) use (&$filter_tasks) {
            if ($task->accept == '0') {
                $task->setAttribute('status', 'rejected');
            } elseif ($task->state == 'progress') {
                $task->setAttribute('status', 'pending');
            } elseif ($task->accept == '1') {
                $task->setAttribute('status', 'accepted');
            } elseif ($task->dedline > now()) {
                $task->setAttribute('status', 'expired');
            } elseif ($task->state == 'accomplished' && $task->accept == null) {
                $task->setAttribute('status', 'accomplished');
            }
            $task->makeHidden(['user', 'report', 'evaluation', 'created_at', 'updated_at',  'state', 'user_id']);
            $task->setAttribute('user_name', $task->user->name);
            $filter_tasks[] = $task;
        });
        // dd($filter_tasks);
        return view('components.tasks.view_tasks')->with('tasks', $filter_tasks);
    }
    public function edit(Task $task)
    {
        return view('components.tasks.update_task')->with('task', $task);
    }
    public function update(REquest $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date',
            'user_id' => 'required'
        ]);
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => $request->user_id
        ]);
        return redirect()->back()->withStatus('task updated successfully');
    }
}
