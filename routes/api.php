<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Models\User;

Route::middleware('auth:api')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::get('users', function (Request $request) {
        $users = User::all();
        return response()->json($users);
    });
    // Tasks 
    Route::resource('tasks', TaskController::class);
    // Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    // Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
    // Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    // Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

