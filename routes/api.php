<?php

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

//tasks
Route::prefix('tasks')->group(function () {
    Route::get('', [TaskController::class, 'index']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::post('', [TaskController::class, 'store']);
    Route::put('{task}', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});
