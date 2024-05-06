<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NamesController;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [EmployeesController::class, 'home'])->name('home')->middleware('auth');
Route::get('/random', [EmployeesController::class, 'random'])->middleware('auth');
Route::get('/regenerate', [EmployeesController::class, 'regenerateData'])->name('regenerate.data')->middleware('auth');


Route::get('Namen', [EmployeesController::class, 'list'])->name('name.list')->middleware('auth');
Route::post('Namen', [EmployeesController::class, 'store'])->middleware('auth');
Route::patch('Namen/{id}', [EmployeesController::class, 'update'])->name('name.update')->middleware('auth');
Route::put('Namen/{id}', [EmployeesController::class, 'upload'])->name('name.upload')->middleware('auth');


Route::delete('Name/delete/{id}', [EmployeesController::class, 'delete'])->name('name.destroy')->middleware('auth');

Route::get('Verlauf', [DatesController::class, 'list'])->middleware('auth');
// Route::get('/VerlaufKochen/{id1}/{id2}/{id3}', [DatesController::class, 'updatePersonKochen'])->middleware('auth');
// Route::get('/VerlaufPraesentieren/{id1}/{id2}/{id3}', [DatesController::class, 'updatePersonPraesentieren'])->middleware('auth');
Route::patch('Verlauf', [DatesController::class, 'updateAllDate'])->name('date.update')->middleware('auth');
Route::get('/DateUpdate/{id}', [DatesController::class, 'updateDate'])->middleware('auth');
Route::delete('Date/delete/{id}', [DatesController::class, 'deleteDate'])->name('date.destroy')->middleware('auth');
Route::put('Date/remove/{id}/{isGekocht}', [DatesController::class, 'removeSingleEmployee'])->name('date.removeEmployee')->middleware('auth');


Route::get('/display-image/{file_hash}', [EmployeesController::class, 'displayImage'])->name('display.image')->middleware('auth');
