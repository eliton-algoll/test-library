<?php

use App\Http\Controllers\Api\Books\CreateLivroAction;
use App\Http\Controllers\Api\Books\DeleteLivroAction;
use App\Http\Controllers\Api\Books\GetLivroAction;
use App\Http\Controllers\Api\Books\ListLivrosAction;
use App\Http\Controllers\Api\Books\UpdateLivroAction;
use Illuminate\Support\Facades\Route;

Route::name('api')->group(function(): void {
    Route::group(['prefix' => 'livro'], function() {
        Route::post('/', CreateLivroAction::class)->name('create.livro');

        Route::get('/{CodLivro}', GetLivroAction::class)->name('get.livro');

        Route::patch('/{CodLivro}', UpdateLivroAction::class)->name('update.livro');

        Route::get('/', ListLivrosAction::class)->name('list.livros');

        Route::delete('/{CodLivro}', DeleteLivroAction::class)->name('delete.livro');
    });
});
