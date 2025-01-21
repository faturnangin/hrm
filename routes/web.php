<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

Route::redirect('/', 'dashboard');
Route::get('/login', [AuthController::class,'index'])->name('login.index');
Route::post('/login/authenticate', [AuthController::class,'login'])->name('auth');
Route::get('/logout', [AuthController::class,'logout'])->name('logout.index');
Route::match(['get', 'post'],'/register', [AuthController::class, 'register'])->name('register');
Route::get('/dashboard', [HomeController::class,'index'])->name('dashboard')->middleware('check.session');
Route::match(['get', 'post'],'/positions', [CoreController::class, 'positions'])->name('positions');
Route::match(['get', 'post'],'/units', [CoreController::class, 'units'])->name('units')->middleware('check.session');
Route::match(['get', 'post'],'/users', [UsersController::class, 'users'])->name('users')->middleware('check.session');
Route::match(['get', 'post'],'/users/add', [UsersController::class, 'adduser'])->name('adduser')->middleware('check.session');
Route::match(['get', 'post'],'/users/edit/{id}', [UsersController::class, 'edituser'])->name('edituser')->middleware('check.session');
Route::match(['get', 'post'],'/profile', [UsersController::class, 'profile'])->name('profile')->middleware('check.session');
Route::match(['get', 'post'],'/log', [CoreController::class, 'log'])->name('log')->middleware('check.session');
