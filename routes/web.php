

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;

Route::get('/', [HomeController::class, 'showLoginRegister'])->name('login.register');
Route::get('/login', [HomeController::class, 'login'])->name('loginProtect');
Route::post('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('registerProtect');
Route::post('/register', [HomeController::class, 'register'])->name('register');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Add your authenticated routes here, such as todo routes
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::post('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::put('/todos/{todo}', [TodoController::class, 'toggle'])->name('todos.toggle');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::get('/todos/filter-and-sort', [TodoController::class, 'filter'])->name('todos.filter');
});