<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   redirect('/home');
// });

Route::get('/dashboard', function () {
  return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
  return view('client.layouts.app');
})->name('home');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('roles', RoleController::class);

require __DIR__ . '/auth.php';
