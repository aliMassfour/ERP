<?php

namespace App\Upload;

use Exception;
use Illuminate\Http\UploadedFile;

abstract class Upload
{
    protected $path = null;
    public abstract function upload();
    public function getPath()
    {
        if ($this->path == null) {
            throw new Exception('there is no file to get the path');
        }
        return $this->path;
    }
}
