<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
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
  Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
  })->name('logout');
});

// Route::resource('roles', RoleController::class);
Route::prefix('roles')->controller(RoleController::class)->name('roles.')->group(function () {
  Route::get('/', 'index')->name('index');
  Route::get('/create', 'create')->name('create');
  Route::post('/', 'store')->name('store');
  Route::get('/{role}', 'show')->name('show');
  Route::get('/{role}/edit', 'edit')->name('edit');
  Route::put('/{role}', 'update')->name('update');
  Route::delete('/{role}', 'destroy')->name('destroy');
})->middleware('permission:view-roles');

Route::prefix('users')->controller(UserController::class)->name('users.')->middleware(['auth'])->group(function () {
  Route::get('/', 'index')->name('index')->middleware('permission:view-users');
  Route::get('/create', 'create')->name('create')->middleware('permission:create-users');
  Route::post('/', 'store')->name('store')->middleware('permission:create-users');
  Route::get('/{user}/edit', 'edit')->name('edit')->middleware('permission:edit-users');
  Route::put('/{user}', 'update')->name('update')->middleware('permission:edit-users');
  Route::delete('/{user}', 'destroy')->name('destroy')->middleware('permission:delete-users');
});

require __DIR__ . '/auth.php';
