<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchPaperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CsvImportController;


use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FeatureMaterials;


Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');

Route::get('/about', [HomeController::class, 'about'])
    ->name('about');

Route::get('/authors', [HomeController::class, 'authorsIndex'])
    ->name('authors');

Route::get('/feature', [HomeController::class, 'feature'])
    ->name('feature');

Route::get('/gallery', [HomeController::class, 'gallery'])
    ->name('gallery');

Route::get('/gallery/{album}', [HomeController::class, 'viewAlbum'])
    ->name('gallery.view');

Route::get('/categories', [HomeController::class, 'categories'])
    ->name('categories');


Route::get('/phpinfo', function () {
    phpinfo();
});




// ----------- ADMIN ROUTES ---------------

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // CSV Import Routes
    Route::get('csv-import', [CsvImportController::class, 'showImportForm'])->name('csv-import.form');
    Route::post('csv-import', [CsvImportController::class, 'import'])->name('csv-import.process');
    Route::get('csv-import/template', [CsvImportController::class, 'downloadTemplate'])->name('csv-import.template');

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


   // Album
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('gallery/view/{album}', [GalleryController::class, 'view'])->name('gallery.view');
    //Route::get('gallery/albums/{album}/images/create', [GalleryController::class, 'create'])->name('albums.images.create');
    Route::get('gallery/albums/{album}/images/create', [GalleryController::class, 'create'])->name('gallery.albums.images.create');

    Route::post('gallery/albums/{album}/images', [GalleryController::class, 'store'])->name('albums.images.store');

    Route::delete('gallery/images/{image}', [GalleryController::class, 'destroy'])->name('gallery.images.destroy');


    //Route::post('/albums/{album}/images', [GalleryController::class, 'store'])->name('albums.images.store');


    Route::get('gallery/albums/create', [AlbumController::class, 'create'])->name('gallery.albums.create');
    Route::post('albums', [AlbumController::class, 'store'])->name('gallery.albums.store');
    Route::delete('gallery/albums/{album}', [AlbumController::class, 'destroy'])->name('gallery.albums.destroy');


    //FeatureMaterial CRUD routes
    Route::get('feature', [FeatureMaterials::class, 'index'])->name('feature.index');
    Route::get('feature/create', [FeatureMaterials::class, 'create'])->name('feature.create');
    Route::post('feature', [FeatureMaterials::class, 'store'])->name('feature.store');
    Route::get('feature/{featureMaterial}', [FeatureMaterials::class, 'show'])->name('feature.show');
    Route::get('feature/{featureMaterial}/edit', [FeatureMaterials::class, 'edit'])->name('feature.edit');
    Route::put('feature/{featureMaterial}', [FeatureMaterials::class, 'update'])->name('feature.update');
    Route::delete('feature/{featureMaterial}', [FeatureMaterials::class, 'destroy'])->name('feature.destroy');


});





// ----------- DASHBOARD ROUTES ---------------
Route::get('/dashboard', [ DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'role:user'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Resource routes for research papers
    Route::resource('research', DashboardController::class);

    Route::get('research/{id}/fulltext', [DashboardController::class, 'fulltext'])->name('research.fulltext.index');

    Route::get('gallery/view/{album}', [DashboardController::class, 'view'])->name('gallery.view');


});





// ----------- PROFILE ROUTES ---------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
