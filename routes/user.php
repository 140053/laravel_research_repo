<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;




Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {




    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::resource('users', UserController::class);
});



