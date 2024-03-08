<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchPatient;
use App\Http\Controllers\SearchMentorController;
use App\Http\Controllers\SearchMedicinesController;
use App\Http\Controllers\SearchOrientationsController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Dashboard and basic views
    Route::view('/', 'welcome');
    Route::view('/painel', 'dashboard')->name('dashboard');
    Route::view('/assistidos', 'patients')->name('patients');
    Route::view('/agendamento', 'schedule')->name('schedule');
    Route::view('/mentores', 'mentors')->name('mentors');

    // Library
    Route::view('/biblioteca/categorias', 'categories')->name('categories');
    Route::view('/biblioteca/autores', 'authors')->name('authors');
    Route::view('/biblioteca/editoras', 'publishers')->name('publishers');

    // Spiritist Center Management
    Route::view('/centro-espirita', 'spiritist-center')->name('spiritistCenter');
    Route::view('/tipos-de-tratamento', 'types-of-treatment')->name('typesOfTreatment');
    Route::view('/usuarios', 'users')->name('users');
    Route::view('/orientacoes', 'orientations')->name('orientations');
    Route::view('/aguas-magnetizadas', 'medicines')->name('medicines');

    // Async Search
    Route::get('/search-patient', SearchPatient::class)->name('searchPatient');
    Route::get('/search-mentor', SearchMentorController::class)->name('searchMentor');
    Route::get('/search-medicine', SearchMedicinesController::class)->name('searchMedicine');
    Route::get('/search-orientation', SearchOrientationsController::class)->name('searchOrientation');
});
