<?php

use App\Http\Controllers\Admin\{AdminTaskController, AdminTodoController};
use App\Http\Controllers\Api\{TaskController, TodoController, Usercontroller};
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

//Users
Route::prefix('users')->group(function () {
    Route::post('/create', [Usercontroller::class, 'store']);
    Route::put('/update/{userId}', [Usercontroller::class, 'update'])->middleware(['auth:sanctum']);
});

//todos
Route::middleware(['auth:sanctum'])->prefix('todos')->group(function () {
    Route::get('', [TodoController::class, 'index']);
    Route::get('{todo}', [TodoController::class, 'show']);
    Route::post('', [TodoController::class, 'store']);
    Route::put('{todo}', [TodoController::class, 'update']);
    Route::delete('{todo}', [TodoController::class, 'destroy']);
    Route::post('{todo}/tasks', [TodoController::class, 'addTask']);
});

//todos admin
Route::middleware(['auth:sanctum', 'can:isSuperAdmin'])->prefix('admin/todos')->group(function () {
    Route::get('', [AdminTodoController::class, 'indexAdmin']);
    Route::get('{todo}', [AdminTodoController::class, 'showAdmin']);
    Route::post('', [AdminTodoController::class, 'storeAdmin']);
    Route::put('{todo}', [AdminTodoController::class, 'updateAdmin']);
    Route::delete('{todo}', [AdminTodoController::class, 'destroyAdmin']);
    Route::post('{todo}/tasks', [AdminTodoController::class, 'addTaskAdmin']);
});

//tasks
Route::middleware(['auth:sanctum'])->prefix('tasks')->group(function () {
    Route::get('', [TaskController::class, 'index']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::post('', [TaskController::class, 'store']);
    Route::put('{task}', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});

//tasks admin
Route::middleware(['auth:sanctum', 'can:isSuperAdmin'])->prefix('admin/tasks')->group(function () {
    Route::get('', [AdminTaskController::class, 'indexAdmin']);
    Route::get('{task}', [AdminTaskController::class, 'showAdmin']);
    Route::post('', [AdminTaskController::class, 'storeAdmin']);
    Route::put('{task}', [AdminTaskController::class, 'updateAdmin']);
    Route::delete('{task}', [AdminTaskController::class, 'destroyAdmin']);
});
