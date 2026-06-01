<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'posts' => [],
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    });
    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return Inertia::render('Profile', [
            'posts' => [],
            'subscriptions' => [],
            'feedPosts' => [],
        ]);
    });
    Route::get('/posts/create', function () {
        //
    });
    Route::post('/posts', function () {
        //
    });
    Route::get('/posts/{post:ulid}/edit', function () {
        //
    });
    Route::delete('/posts/{post:ulid}', function () {
        //
    });
});

Route::get('/posts/{post:ulid}', function () {
    //
});
