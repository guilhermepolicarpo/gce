<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/patients', function () {
    return view('patients');
})->name('patients');

Route::middleware(['auth:sanctum', 'verified'])->get('/schedule', function () {
    return view('schedule');
})->name('schedule');

Route::middleware(['auth:sanctum', 'verified'])->get('/mentors', function () {
    return view('mentors');
})->name('mentors');

Route::middleware(['auth:sanctum', 'verified'])->get('/spiritist-center', function () {
    return view('spiritist-center');
})->name('spiritistCenter');

Route::middleware(['auth:sanctum', 'verified'])->get('/types-of-treatment', function () {
    return view('types-of-treatment');
})->name('typesOfTreatment');

Route::middleware(['auth:sanctum', 'verified'])->get('/users', function () {
    return view('users');
})->name('users');