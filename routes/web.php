<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchPaperController;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');





// ----------- ADMIN ROUTES ---------------

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');
    
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    // Import Route
    Route::get('research/import', [ResearchPaperController::class, 'showImportForm'])->name('research.import.index');
    
    Route::post('research/import/preview', [ResearchPaperController::class, 'previewImport'])->name('research.import.preview');

    Route::post('research/import', [ResearchPaperController::class, 'handleImport'])->name('research.import.process');


    // Resource routes for research Add View delete update
    Route::resource('research', ResearchPaperController::class);   

    Route::get('research/{id}/fulltext', [ResearchPaperController::class, 'fulltext'])->name('research.fulltext.index');
});




// ----------- DASHBOARD ROUTES ---------------
Route::get('/dashboard', [ DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'role:user'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Resource routes for research papers
    Route::resource('research', DashboardController::class);

    Route::get('research/{id}/fulltext', [DashboardController::class, 'fulltext'])->name('research.fulltext.index');

});









 


    




    
// ----------- PROFILE ROUTES ---------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
