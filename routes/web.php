<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->middleware('is_user');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','is_user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard')->middleware(['auth','admin']);

// Route::post('/admin/users/store', [AdminController::class, 'store'])->name('admin.users.store')->middleware(['auth','admin']);

Route::post('/members', [AdminController::class, 'store'])->name('members.store');
Route::get('/members/{member}/edit', [AdminController::class, 'edit'])->name('admin.members.edit');
Route::put('/members/{member}', [AdminController::class, 'update'])->name('admin.members.update');
Route::delete('/admin/members/{member}', [AdminController::class, 'destroy'])->name('admin.members.destroy');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});








Route::get('/fetch-products', [AdminController::class, 'fetchProducts']);

Route::get('/products', [AdminController::class, 'index']);

Route::get('/fetch-carts', [AdminController::class, 'fetchCarts']);

Route::get('/carts', [AdminController::class, 'indexcart']);

Route::get('/fetch-todos', [AdminController::class, 'fetchTodos']);

Route::get('/todos', [AdminController::class, 'indextodo']);

Route::get('/fetch-quotes', [AdminController::class, 'fetchquotes']);

Route::get('/quotes', [AdminController::class, 'indexquote']);



Route::get('/api/environments/{environment}', [AdminController::class, 'show']);











