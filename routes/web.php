<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchPaperController;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('research/import', [ResearchPaperController::class, 'showImportForm'])->name('research.import.index');
    Route::post('research/import', [ResearchPaperController::class, 'handleImport'])->name('research.import.process');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');


Route::get('/dashboard', [ DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'role:user'])->prefix('dashboard')->name('dashboard.')->group(function () {
    

    // Resource routes for research papers
    Route::resource('research', DashboardController::class);

    
});




Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    //admin route
    //Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes for research
    Route::resource('research', ResearchPaperController::class);   
        
    // Import routes
    //Route::get('research/import', [ResearchPaperController::class, 'showImportForm'])->name('research.import.index');
    //Route::post('research/import', [ResearchPaperController::class, 'handleImport'])->name('research.import.process');
    
});



//Route::get('/admin/research/import', [ResearchPaperController::class, 'showImportForm'])
//    ->middleware(['auth'])
//    ->name('import.index');


    




    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
