<?php

use App\Models\User;

if(!function_exists('to_user'))
{
    function to_user($user) : User
    {
        return $user;
    }

    if(!function_exists('upload_file'))
{
    function upload_file($request_file, $prefix, $folder_name)
    {
        $extension = $request_file->getClientOriginalExtension();
        $file_to_store = $prefix . '_' . time() . '.' . $extension;
        $request_file->storeAs('public/' . $folder_name, $file_to_store);
        return $folder_name.'/'.$file_to_store;
    }
}

if(!function_exists('delete_file_if_exist'))
{
    function delete_file_if_exist($file)
    {
        if(Storage::exists('public/'.$file))
            Storage::delete('public/'.$file);
    }
}
}
