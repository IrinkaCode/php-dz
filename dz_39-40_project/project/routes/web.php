<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

// Публичные маршруты постов: сгруппированы под /posts,
// {post} и {category:slug} — через route model binding (Laravel сам ищет модель и кидает 404).
Route::prefix('posts')
    ->name('posts.')
    ->controller(PostController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/category/{category:slug}', 'category')->name('category');
        Route::get('/{post}', 'show')->name('show');
    });

// Все маршруты админки сгруппированы по префиксу /admin и имени admin.*
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminIndexController::class)->name('index');

        Route::prefix('posts')
            ->name('posts.')
            ->controller(AdminPostController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->where('id', '[0-9]+')->name('edit');
                Route::put('/{id}', 'update')->where('id', '[0-9]+')->name('update');
                Route::delete('/{id}', 'destroy')->where('id', '[0-9]+')->name('destroy');
            });

        Route::prefix('categories')
            ->name('categories.')
            ->controller(AdminCategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->where('id', '[0-9]+')->name('edit');
                Route::put('/{id}', 'update')->where('id', '[0-9]+')->name('update');
                Route::delete('/{id}', 'destroy')->where('id', '[0-9]+')->name('destroy');
            });
    });
