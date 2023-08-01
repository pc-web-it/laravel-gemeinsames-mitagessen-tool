<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NamesController;

Route::get('/', function () {
    return view('home');
});

/*Route::get('/Namen', [NamesController::class, 'testing']);*/

Route::get('Namen', [NamesController::class, 'create']);
Route::post('Namen', [NamesController::class, 'store']);
/*
[NamesController::class, 'testing'],*/