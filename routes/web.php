<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

// Route::view() — хелпер для статических страниц без контроллера.
// Аналог: в Next.js pages/about.tsx автоматически становится маршрутом /about.
// Здесь нужно явно объявить: URI → имя вьюшки.
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
