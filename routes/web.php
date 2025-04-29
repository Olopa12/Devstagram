<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;

// Página principal
Route::get('/', fn() => view('principal'));

// ——————————————————————————
// Autenticación
// ——————————————————————————
Route::get('/crear-cuenta', [RegisterController::class, 'index'])->name('register');
Route::post('/crear-cuenta', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// ——————————————————————————
// Perfil de usuario
// Middleware: auth
// ——————————————————————————
Route::middleware('auth')->group(function() {
    Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');
});

// ——————————————————————————
// Posts
// ——————————————————————————
Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index');
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');
});
// Detalle de un post
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');
    
// ——————————————————————————
// Comentarios
// ——————————————————————————
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->
name('comentarios.store');

// ——————————————————————————
// Imágenes
// —————————————————————————
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// ——————————————————————————
// Likes
// ——————————————————————————
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// ——————————————————————————
// Seguir usuarios
// ——————————————————————————
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

