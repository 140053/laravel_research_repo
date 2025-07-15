<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchPaperController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');


Route::get('/dashboard', [ DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');



//Admin Route

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    //research papers
    Route::resource('research', ResearchPaperController::class);    

});




    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
