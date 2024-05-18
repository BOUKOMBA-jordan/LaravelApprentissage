<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

// Définir la route de base pour la vue 'welcome'
Route::get('/', function () {
    return view('welcome');
});

// Routes pour l'authentification
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);

// Définir les routes avec un préfixe 'blog' et un nom 'blog.'
Route::prefix('blog')->name('blog.')->group(function () {
    // Route pour la méthode 'index' du BlogController
    Route::get('/', [BlogController::class, 'index'])->name('index');

    // Routes pour créer et stocker un nouvel article
    Route::get('/new', [BlogController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/new', [BlogController::class, 'store'])->name('store')->middleware('auth');

    // Route pour éditer et mettre à jour un article
    Route::get('/{post}/edit', [BlogController::class, 'edit'])->name('edit')->middleware('auth');
    Route::patch('/{post}/edit', [BlogController::class, 'update'])->name('update')->middleware('auth');

    // Route pour la méthode 'show' du BlogController
    Route::get('/{slug}-{post}', [BlogController::class, 'show'])->where([
        'post' => '[0-9]+', // Utiliser 'post' au lieu de 'id'
        'slug' => '[a-z0-9\-]+'
    ])->name('show');
});
