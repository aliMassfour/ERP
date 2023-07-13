<?php

namespace App\Upload;

use App\Models\Task;
use Illuminate\Http\UploadedFile;

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
        $this->path = $this->file->store('Reports/' . $this->task->id, 'public');
    }
    
}
