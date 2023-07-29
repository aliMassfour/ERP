<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Task;
use App\Notification\ReportNotification;
use App\Upload\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    private $notification;
    public function __construct()
    {
        $this->notification = new ReportNotification();
    }
    public function report(Request $request, Task $task)
    {
        $role = Role::where('name', 'admin')->first();
        $user = $role->users()->first();
        $file = $request->file('report');
        $upload = new FileUpload($file, $task);
        $upload->upload();
        $path = $upload->getPath();
        $task->report = $path;
        $task->state = 'accomplished';
        $task->accept=null;
        if ($task->save()) {
            $this->notification->notificate($user, $task);
            return redirect()->route('user.tasks')->withStatus('upload the report success');
        }
        return redirect()->route('user.tasks')->withStatus('error occured please try again');
    }
    public function download(Task $task)
    {
        $path = Storage::disk('public')->path($task->report); 
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // add more MIME types as needed
        ];
        $headers = [
            'Content-Type' => $mimeTypes[$extension] ?? 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $task->name . '.' . $extension . '"',
        ];
        return response()->download($path, $task->name . '.' . $extension, $headers);
    }
}
