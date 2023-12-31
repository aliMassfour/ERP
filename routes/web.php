<?php

use App\Http\Controllers\Dashboard\CKeditorController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Task\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;


Route::post('ckeditor/image_upload', [CKeditorController::class, 'upload'])->name('upload');

Route::get('/', [PagesController::class, 'index'])->name('index');

Route::get('/dashboard', [PagesController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/profile', [UsersController::class, 'edit_profile'])->name('profile.edit');
Route::put('/dashboard/profile', [UsersController::class, 'update_profile'])->name('profile.update');
Route::put('/dashboard/profile/password', [UsersController::class, 'change_password'])->name('profile.password');

Route::Resource('/dashboard/users', UsersController::class)->except(['show']);

Route::get('exportView', [ExportController::class, 'exportView']);
Route::get('export', [ExportController::class, 'export'])->name('export');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/index/{user}', [TaskController::class, 'index'])->name('task.index');
    Route::delete('/task/destroy/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::put('/task/accept/{task}', [TaskController::class, 'accept'])->name('task.accept');
    Route::put('/task/reject/{task}', [TaskController::class, 'reject'])->name('task.reject');

    Route::get('/task/view', [TaskController::class, 'view'])->name('task.view');
    Route::get('/task/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/task/update/{task}', [TaskController::class, 'update'])->name('task.update');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/tasks', [TaskController::class, 'UserTaskList'])->name('user.tasks');
    Route::get('/users/salarys', [UsersController::class, 'getSalary'])->name('users.salary');
    Route::put('/salary/pay/{user}', [UsersController::class, 'pay'])->name('users.pay');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/notification', [NotificationController::class, 'UnreadNotification'])->name('notificatoion');
});
Route::group(['middleware' => 'auth'], function () {
    Route::post('/task/report/{task}', [ReportController::class, 'report'])->name('task.report');
    Route::get('/report/download/{task}', [ReportController::class, 'download'])->name('task.report.download');
});
Route::get('/test', function () {
    $task = Task::find(3);
    return  $task->isReported();
});
