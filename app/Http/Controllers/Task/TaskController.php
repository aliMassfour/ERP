<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
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
        $tasks = $user->tasks;
        return view('components.tasks.index')->with('tasks', $tasks);
    }
    public function accept(Request $request, Task $task)
    {
        $this->validate($request, [
            'rating' => 'required'
        ]);
        $task->evaluation = $request->rating;
        $task->accept = '1';
        if ($task->save()) {
            return redirect()->route('task.index',$task->user->id)->withStatus('accept the task success');
        } else {
            return redirect()->route('task.index',$task->user->id)->withStatus('error ocurred please try again');
        }
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('dashboard')->withStatus('delete the task success');
    }
}
