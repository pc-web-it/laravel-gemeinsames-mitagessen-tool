<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\GewinnspielController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LuckyWinnersController;
use App\Http\Controllers\RecipesController;

// Routes for login page
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Routes for generator page
Route::get('/', [EmployeesController::class, 'home'])->name('home')->middleware('auth');
Route::get('/random', [EmployeesController::class, 'random'])->middleware('auth');
Route::get('/regenerate', [EmployeesController::class, 'regenerateData'])->name('regenerate.data')->middleware('auth');

// Routes for the list of employees
Route::get('Namen', [EmployeesController::class, 'list'])->name('name.list')->middleware('auth');
Route::post('Namen', [EmployeesController::class, 'store'])->middleware('auth');
Route::patch('Namen/{id}', [EmployeesController::class, 'update'])->name('name.update')->middleware('auth');
Route::put('Namen/{id}', [EmployeesController::class, 'upload'])->name('name.upload')->middleware('auth');
Route::delete('Name/delete/{id}', [EmployeesController::class, 'delete'])->name('name.destroy')->middleware('auth');

// Routes for Verlauf page
Route::get('Verlauf', [DatesController::class, 'list'])->middleware('auth');
Route::patch('Verlauf', [DatesController::class, 'updateAllDate'])->name('date.update')->middleware('auth');
Route::get('/DateUpdate/{id}', [DatesController::class, 'updateDate'])->middleware('auth');
Route::delete('Date/delete/{id}', [DatesController::class, 'deleteDate'])->name('date.destroy')->middleware('auth');
Route::put('Date/remove/{id}/{isGekocht}', [DatesController::class, 'removeSingleEmployee'])->name('date.removeEmployee')->middleware('auth');

// Route to show the profile image of employee
Route::get('/display-image/{file_hash}', [EmployeesController::class, 'displayImage'])->name('display.image')->middleware('auth');

Route::get('/gewinnspiel', [GewinnspielController::class,'index'])->name('gewinnspiel')->middleware('auth');


Route::post('/upload-csv', [FileUploadController::class, 'uploadCSV'])->name('upload.csv')->middleware('auth');
Route::get('/generate-random-name', [FileUploadController::class, 'generateRandomName'])->name('generate.random.name')->middleware('auth');


Route::get('/gewinner', [LuckyWinnersController::class,'index'])->name('gewinner')->middleware('auth');
Route::put('/gewinner', [LuckyWinnersController::class, 'store'])->name('winner.store')->middleware('auth');

// Routes for Recipes
Route::get('/recipes', [RecipesController::class, 'index'])->middleware('auth');
Route::get('/recipes/create', [RecipesController::class, 'create'])->middleware('auth');
Route::post('/recipes', [RecipesController::class, 'store'])->middleware('auth');
Route::get('/recipes/{recipe}', [RecipesController::class, 'show'])->middleware('auth');
Route::get('/recipes/{recipe}/edit', [RecipesController::class, 'edit'])->middleware('auth');
Route::patch('/recipes/{recipe}', [RecipesController::class, 'update'])->middleware('auth');
Route::delete('recipes/{recipe}', [RecipesController::class, 'destroy'])->middleware('auth');

// Routes to show images and PDFs in the web
Route::get('/display-recipeImage/{file_hash}', [RecipesController::class, 'displayRecipeImage'])->name('display.recipeImage')->middleware('auth');
Route::get('/display-pdf/{file_hash}', [RecipesController::class, 'displayPdf'])->name('display.pdf')->middleware('auth');
