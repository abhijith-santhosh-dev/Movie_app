<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::middleware(['auth'])->group(function () {
    Route::get('/home', [MovieController::class, 'index'])->name('home');
    
    // Movie routes
    Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
    Route::get('/movies/{id}', [MovieController::class, 'showDetails'])->name('movies.details');
    
    // Favorite movies routes
    Route::post('/favorites/add', [MovieController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/favorites/{id}', [MovieController::class, 'removeFromFavorites'])->name('favorites.remove');
});