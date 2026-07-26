<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(static function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/create-post', [PostController::class, 'create'])->name('author.posts.create');
    Route::post('/create-post', [PostController::class, 'store'])->name('author.posts.store');
    Route::get('/author/{user}/{post:slug}/edit', [PostController::class, 'edit'])->name('author.posts.edit');
    Route::put('/author/{user}/{post:slug}', [PostController::class, 'update'])->name('author.posts.update');
    Route::delete('/author/{user}/{post:slug}', [PostController::class, 'destroy'])->name('author.posts.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/author/{user}/{post:slug}/comment', [CommentController::class, 'store'])->name('author.posts.comment');
});

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/tag/{tag:name}', [PostController::class, 'tag'])->name('tag');
Route::get('/author/{user}', [PostController::class, 'author'])->name('author.posts.index');
Route::post('/author/{user}/subscribe', [ProfileController::class, 'subscribe'])->name('profile.subscribe');
Route::post('/author/{user}/unsubscribe', [ProfileController::class, 'unsubscribe'])->name('profile.unsubscribe');
Route::get('/author/{user}/{post:slug}', [PostController::class, 'show'])->name('author.posts.show');
