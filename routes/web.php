<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchPatient;
use App\Http\Controllers\GetBookAuthors;
use App\Http\Controllers\GetBookPublisher;
use App\Http\Controllers\GetBookCategories;
use App\Http\Controllers\GetBooks;
use App\Http\Controllers\SearchMentorController;
use App\Http\Controllers\GetIncarnateBookAuthors;
use App\Http\Controllers\SearchMedicinesController;
use App\Http\Controllers\SearchOrientationsController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Dashboard and basic views
    Route::view('/', 'welcome');
    Route::view('/painel', 'dashboard')->name('dashboard');
    Route::view('/assistidos', 'patients')->name('patients');
    Route::view('/agendamento', 'schedule')->name('schedule');
    Route::view('/mentores', 'mentors')->name('mentors');
    Route::get('/atendimento/{treatmentId}', function ($treatmentId) {
        return view('view-treatment', ['treatmentId' => $treatmentId]);
    })->name('treatmentView');
    Route::get('/atendimentos/{patientId}', function ($patientId) {
        return view('treatments', ['patientId' => $patientId]);
    })->name('patientTreatments');
    Route::get('/atendimento/{appointmentId}/create', function ($appointmentId) {
        return view('create-treatment', ['appointmentId' => $appointmentId]);
    })->name('TreatmentCreate');

    // Library
    Route::view('/biblioteca/categorias', 'categories')->name('categories');
    Route::view('/biblioteca/autores', 'authors')->name('authors');
    Route::view('/biblioteca/editoras', 'publishers')->name('publishers');
    Route::view('/biblioteca/livros', 'books')->name('books');
    Route::view('/biblioteca/emprestimos', 'checkouts')->name('checkouts');

    // Spiritist Center Management
    Route::view('/centro-espirita', 'spiritist-center')->name('spiritistCenter');
    Route::view('/tipos-de-tratamento', 'types-of-treatment')->name('typesOfTreatment');
    Route::view('/usuarios', 'users')->name('users');
    Route::view('/orientacoes', 'orientations')->name('orientations');
    Route::view('/aguas-magnetizadas', 'medicines')->name('medicines');

    // Async Search/Get
    Route::get('/search-patient', SearchPatient::class)->name('searchPatient');
    Route::get('/search-mentor', SearchMentorController::class)->name('searchMentor');
    Route::get('/search-medicine', SearchMedicinesController::class)->name('searchMedicine');
    Route::get('/search-orientation', SearchOrientationsController::class)->name('searchOrientation');
    Route::get('/get-categories', GetBookCategories::class)->name('getBookCategories');
    Route::get('/get-publishers', GetBookPublisher::class)->name('getBookPublisher');
    Route::get('/get-authors', GetIncarnateBookAuthors::class)->name('getIncarnateBookAuthors');
    Route::get('/get-spiritual-authors', GetBookAuthors::class)->name('getBookAuthors');
    Route::get('/get-books', GetBooks::class)->name('getBooks');
});
