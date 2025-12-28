<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('login', [UserController::class, 'login'])->name('login');

// protected routes
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('me', [UserController::class, 'me'])->name('me');

    Route::prefix('tasks')->group(function(){
        Route::get('/', [TaskController::class, 'my'])->name('task:my');
        Route::post('/', [TaskController::class, 'create'])->name('task:create');
        Route::get('/{task}', [TaskController::class, 'detail'])->name('task:detail')->middleware('can:view,task');
        Route::put('/{task}', [TaskController::class, 'update'])->name('task:update')->middleware('can:update,task');
        Route::delete('/{task}', [ TaskController::class, 'delete'])->name('task:delete')->middleware('can:delete,task');
    });
});
