<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\SecurityController;
use App\Http\Middleware\ApiAuth;
use App\Http\Middleware\ApiGuest;
use App\Http\Middleware\Cors;
use App\Http\Middleware\EnsureAuthor;
use Illuminate\Support\Facades\Route;

Route::middleware([Cors::class])->group(function () {
    Route::middleware([ApiGuest::class])->group(function () {
        Route::post('/login', [SecurityController::class, 'login'])
            ->name('api.login');

        Route::post('/register', [SecurityController::class, 'register'])
            ->name('api.register');
    });

    Route::middleware([ApiAuth::class])
        ->get('/logout', [SecurityController::class, 'logout'])
        ->name('api.logout');

    Route::prefix('/articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])
            ->name('api.articles.index');

        Route::get('/{article}', [ArticleController::class, 'read'])
            ->name('api.articles.read');

        Route::middleware([ApiAuth::class])->group(function () {
            Route::post('/', [ArticleController::class, 'create'])
                ->name('api.articles.create');

            Route::middleware([EnsureAuthor::class])->group(function () {
                Route::patch('/{article}', [ArticleController::class, 'update'])
                    ->name('api.articles.update');

                Route::delete('/{article}', [ArticleController::class, 'delete'])
                    ->name('api.articles.delete');
            });
        });
    });
});