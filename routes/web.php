<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('publicaciones.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/publicaciones', [PublicacionController::class, 'index'])->name('publicaciones.index');

Route::middleware(['auth'])->group(function (){
    Route::get('/publicacion/crear', [PublicacionController::class, 'create'])->name('publicaciones.crear');

    Route::post('publicacion/crear', [PublicacionController::class, 'store'])
    ->name('publicaciones.store');


    Route::get('/publicacion/editar/{id}', [PublicacionController::class, 'edit'])->name('publicacion.editar');

    Route::put('publicacion/editar/{id}', [PublicacionController::class, 'update'])->name('publicacion.update');


    Route::get('comentarios', [ComentarioController::class, 'create'])->name('comentarios.create');

    Route::post('comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');

    Route::delete('/eliminar/publicacion/{id}', [PublicacionController::class, 'destroy'])->name('publicacion.destroy');
});

// routes/web.php
Route::middleware('admin')->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');

    Route::get('/categorias/crear', [CategoriaController::class, 'create'])->name('categorias.create');

    Route::post('/categorias/crear', [CategoriaController::class, 'store'])->name('categorias.store');

    Route::get('/categoria/editar/{id}', [CategoriaController::class, 'edit'])->name('categorias.edit');

    Route::put('/categoria/editar/{id}', [CategoriaController::class, 'update'])->name('categorias.update');

    Route::delete('/eliminar/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});

Route::get('publicacion/{id}',[PublicacionController::class, 'show'])
->name('publicacion.show');

require __DIR__.'/auth.php';
