<?php

namespace App\Upload;

use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Upload
{
    private $task = null;
    private $file;
    public function __construct(UploadedFile $file, Task $task)
    {
        $this->file = $file;
        $this->task = $task;
    }
    public function upload()
    {
        $extension = $this->file->getClientOriginalExtension(); 
        $filename = $this->task->id . '_' . $this->task->name . '.' . $extension;
        $path = Storage::disk('public')->putFileAs('reports/'.$this->task->id, $this->file, $filename);
        $this->path = $path;
    }
}
