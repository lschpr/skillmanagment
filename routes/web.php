<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// De 'welcome' pagina is voor iedereen toegankelijk (publiek).
Route::get('/', function () {
    return view('welcome');
});

/**
 * Route::middleware(['auth', 'verified']): 
 * Dit is een 'Group' van routes die beveiligd zijn.
 * 'auth': Je moet ingelogd zijn.
 * 'verified': Je moet je e-mail bevestigd hebben (standard Breeze).
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Het dashboard: de 'home' voor ingelogde gebruikers.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Route::resource: Dit is een hele krachtige Laravel functie.
     * Het maakt in één keer alle 7 standaard routes aan voor CRUD (Create, Read, Update, Delete).
     * Denk aan: assignments.index, assignments.create, assignments.store, etc.
     */
    Route::resource('assignments', \App\Http\Controllers\AssignmentController::class);
    
    // Losse routes voor het sollicitatie-proces (Applications).
    // Ik gebruik verschillende HTTP verbs: POST voor opslaan, GET voor bekijken, PATCH voor updaten.
    Route::post('/applications', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications', [\App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');
    Route::patch('/applications/{application}', [\App\Http\Controllers\ApplicationController::class, 'update'])->name('applications.update');

    // Route met een parameter {user} om een specifiek publiek profiel te tonen.
    Route::get('/profile/{user}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');

    // Berichten-systeem routes: overzicht, gesprek bekijken en bericht sturen.
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    /**
     * Admin Routes: deze zijn extra beveiligd in de AdminController.
     */
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::patch('/admin/users/{user}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('admin.users.toggle');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/admin/assignments/{assignment}', [\App\Http\Controllers\AdminController::class, 'destroyAssignment'])->name('admin.assignments.destroy');
});

// Profiel-beheer van Breeze: hier kun je je eigen wachtwoord en email aanpassen.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dit laadt de routes voor Login, Registratie en Wachtwoord vergeten (auth.php).
require __DIR__.'/auth.php';
