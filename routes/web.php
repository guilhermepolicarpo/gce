<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchPatient;
use App\Http\Controllers\SearchMentorController;
use App\Http\Controllers\SearchMedicinesController;
use App\Http\Controllers\SearchOrientationsController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/painel', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/assistidos', function () {
    return view('patients');
})->name('patients');

Route::middleware(['auth:sanctum', 'verified'])->get('/agendamento', function () {
    return view('schedule');
})->name('schedule');

Route::middleware(['auth:sanctum', 'verified'])->get('/mentores', function () {
    return view('mentors');
})->name('mentors');



Route::middleware(['auth:sanctum', 'verified'])->get('/centro-espirita', function () {
    return view('spiritist-center');
})->name('spiritistCenter');

Route::middleware(['auth:sanctum', 'verified'])->get('/tipos-de-tratamento', function () {
    return view('types-of-treatment');
})->name('typesOfTreatment');

Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios', function () {
    return view('users');
})->name('users');

Route::middleware(['auth:sanctum', 'verified'])->get('/orientacoes', function () {
    return view('orientatios');
})->name('orientatios');

Route::middleware(['auth:sanctum', 'verified'])->get('/aguas-magnetizadas', function () {
    return view('medicines');
})->name('medicines');


// Async Search
Route::middleware(['auth:sanctum', 'verified'])->get('/search-patient', SearchPatient::class)->name('searchPatient');
Route::middleware(['auth:sanctum', 'verified'])->get('/search-mentor', SearchMentorController::class)->name('searchMentor');
Route::middleware(['auth:sanctum', 'verified'])->get('/search-medicine', SearchMedicinesController::class)->name('searchMedicine');
Route::middleware(['auth:sanctum', 'verified'])->get('/search-orientation', SearchOrientationsController::class)->name('searchOrientation');
