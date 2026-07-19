<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(static function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // Route::post('/author/{user}/{post:slug}/comment', [CommentController::class, 'store'])->name('author.posts.comment');
});

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/tags/{tag:name}', [PostController::class, 'tag'])->name('tag');
Route::get('/author/{user}', [PostController::class, 'author'])->name('author.posts');
Route::post('/author/{user}/subscribe', [ProfileController::class, 'subscribe'])->name('profile.subscribe');
Route::post('/author/{user}/unsubscribe', [ProfileController::class, 'unsubscribe'])->name('profile.unsubscribe');
Route::get('/author/{user}/{post:slug}', [PostController::class, 'show'])->name('author.posts.show');
