<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;

Route::middleware([Cors::class])->group(function () {
    Route::prefix('/articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])
            ->name('api.articles.index');
        Route::post('/', [ArticleController::class, 'create'])
            ->name('api.articles.create');
        Route::get('/{article}', [ArticleController::class, 'read'])
            ->name('api.articles.read');
        Route::patch('/{article}', [ArticleController::class, 'update'])
            ->name('api.articles.update');
        Route::delete('/{article}', [ArticleController::class, 'delete'])
            ->name('api.articles.delete');
    });
});