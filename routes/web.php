<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchPaperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticlesController;


use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AlbumController;


Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');

Route::get('/about', [HomeController::class, 'about'])
    ->name('about');

Route::get('/authors', [HomeController::class, 'authorsIndex'])
    ->name('authors');

Route::get('/browse', [HomeController::class, 'browse'])
    ->name('browse');

Route::get('/categories', [HomeController::class, 'categories'])
    ->name('categories');




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
    //Route::get('research', [ResearchPaperController::class, 'index'])->name('research.import')

    Route::get('research/pending/index', [ResearchPaperController::class, 'pending'])->name('research.pending.index');
    Route::get('research/{id}/fulltext', [ResearchPaperController::class, 'fulltext'])->name('research.fulltext.index');

    Route::put('research/{paper}/approve', [ResearchPaperController::class, 'approve'])->name('research.approve');
    Route::put('research/mass-approve', [ResearchPaperController::class, 'massApprove'])->name('research.mass-approve');
    Route::post('research/bulk-action', [ResearchPaperController::class, 'bulkAction'])->name('research.bulkAction');

    //Articles
    Route::resource('articles', ArticlesController::class);
    Route::delete('articles/images/{image}', [ArticlesController::class, 'deleteImage'])->name('articles.deleteImage');


    //Gallery 
    //Route::resource('albums', GalleryControllers::class);
   //// Route::get('albums', [GalleryControllers::class, 'index'])->name('albums.index');
   // Route::get('albums/create', [GalleryControllers::class, 'create'])->name('albums.create');
   // Route::get('albums/store', [GalleryControllers::class, 'store'])->name('albums.store');
   // Route::post('albums/store', [GalleryControllers::class, 'store'])->name('albums.store');
    
   // Route::get('/albums/{album}/edit', [GalleryControllers::class, 'edit'])->name('admin.albums.edit');

    //Route::post('albums/edit', [GalleryControllers::class, 'edit'])->name('albums.edit');
   // Route::post('albums/destroy', [GalleryControllers::class, 'destroy'])->name('albums.destroy');
   // Route::post('albums/update', [GalleryControllers::class, 'update'])->name('albums.update');
   
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('gallery/albums/{album}/images/create', [GalleryController::class, 'create'])->name('albums.images.create');
    Route::get('gallery/albums/{album}/images/create', [GalleryController::class, 'create'])->name('gallery.albums.images.create');

    Route::post('/gallery/albums/{album}/images', [GalleryController::class, 'store'])->name('albums.images.store');

    //Route::post('/albums/{album}/images', [GalleryController::class, 'store'])->name('albums.images.store');


    Route::get('gallery/albums/create', [AlbumController::class, 'create'])->name('gallery.albums.create');
    Route::post('albums', [AlbumController::class, 'store'])->name('gallery.albums.store');

   

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
require __DIR__.'/user.php';
