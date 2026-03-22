<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// De 'welcome' pagina is voor iedereen toegankelijk (publiek).
Route::get('/', function () {
    return view('welcome');
});

/**
 * Route::middleware(['auth', 'verified']): 
 * Een 'Group' van routes die beveiligd zijn. Je moet ingelogd zijn ('auth') 
 * en je email geverifieerd hebben ('verified') om hierbij te kunnen.
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Het dashboard toont relevante info op basis van de rol (Student/Bedrijf).
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Route::resource: Maakt in één keer 7 routes aan voor CRUD acties:
     * index, create, store, show, edit, update, destroy.
     * Handig voor standaard 'opdrachten' beheer.
     */
    Route::resource('assignments', \App\Http\Controllers\AssignmentController::class);
    
    // Handmatige routes voor acties die niet in een standaard resource vallen.
    Route::post('/applications', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
    Route::patch('/applications/{application}', [\App\Http\Controllers\ApplicationController::class, 'update'])->name('applications.update');

    // Berichten systeem tussen studenten en bedrijven.
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    /**
     * Extra beveiliging binnen de groep: Alleen voor de Admin.
     * De AdminController handhaaft dit ook nog eens voor de zekerheid.
     */
    Route::middleware(['auth'])->group(function() {
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::patch('/admin/users/{user}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('admin.users.toggle');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::delete('/admin/assignments/{assignment}', [\App\Http\Controllers\AdminController::class, 'destroyAssignment'])->name('admin.assignments.destroy');
    });
});

// Standaard Breeze profiel beheer routes (geleverd door Laravel starter kits).
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
