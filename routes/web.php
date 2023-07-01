<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TaskController::class, 'getTasks'])->middleware(['auth', 'verified'])->name('tasks');

Route::get('/tasks', [TaskController::class, 'getTasks'])->middleware(['auth', 'verified'])->name('tasks');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::middleware(['auth', 'admin_or_manager'])->group(function () {
    Route::get('/add-tasks', [TaskController::class, 'index'])->name('add-tasks');
    Route::post('/add-task', [TaskController::class, 'store'])->name('add-task');
    Route::get('/add-group', [TaskGroupController::class, 'index'])->name('add-group');
    Route::post('/add-group', [TaskGroupController::class, 'store'])->name('add-group');

    Route::delete('/task/', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::post('/task/task-completed', [TaskController::class, 'complete'])->name('task.complete');
    Route::post('/task/task-canceled', [TaskController::class, 'cancel'])->name('task.cancel');
    Route::post('task/task-edit', [TaskController::class, 'edit'])->name('task.edit');

    Route::get('task/edit/{id}', [TaskController::class, 'getTaskk']);

    Route::post('/delete-group', [TaskGroupController::class, 'destroy']);
    Route::get('/edit-group/{id}', [TaskGroupController::class, 'getGroup']);
    Route::post('/edit-group', [TaskGroupController::class, 'edit'])->name('group.edit');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/user/edit-user', [UserController::class, 'edit'])->name('user');
    Route::get('/user/{id?}', [UserController::class, 'getUser'])->name('user');
    Route::get('/user-types', [UserController::class, 'getTypes'])->name('user.types');
    Route::post('/add-type', [UserController::class, 'addType'])->name('add-type');
    Route::post('/delete-type', [UserController::class, 'delete_type'])->name('delete-type');

});

Route::middleware(['auth', 'executant_or_admin_or_manager'])->group(function () {
    Route::get('/task/{id}/', [TaskController::class, 'getTask'])->name('task');
    Route::post('/task/{id}/complete', [TaskController::class, 'executantComplete'])->name('check.complete');
    Route::post('task/{id}/send-comment', [CommentController::class, 'store']);
    Route::post('task/{id}/{comment_id}/comment-delete', [CommentController::class, 'destroy']);
});


require __DIR__ . '/auth.php';
