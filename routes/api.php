<?php

use App\Http\Controllers\Api\Books\CreateAutorAction;
use App\Http\Controllers\Api\Books\CreateLivroAction;
use App\Http\Controllers\Api\Books\DeleteAutorAction;
use App\Http\Controllers\Api\Books\DeleteLivroAction;
use App\Http\Controllers\Api\Books\GetAutorAction;
use App\Http\Controllers\Api\Books\GetLivroAction;
use App\Http\Controllers\Api\Books\ListAutoresAction;
use App\Http\Controllers\Api\Books\ListLivrosAction;
use App\Http\Controllers\Api\Books\UpdateAutorAction;
use App\Http\Controllers\Api\Books\UpdateLivroAction;
use Illuminate\Support\Facades\Route;

Route::name('api')->group(function(): void {
    Route::group(['prefix' => 'livro'], function() {
        Route::post('/', CreateLivroAction::class)->name('create.livro');

        Route::get('/{codLivro}', GetLivroAction::class)->name('get.livro');

        Route::patch('/{codLivro}', UpdateLivroAction::class)->name('update.livro');

        Route::get('/', ListLivrosAction::class)->name('list.livros');

        Route::delete('/{CodLivro}', DeleteLivroAction::class)->name('delete.livro');
    });

    Route::group(['prefix' => 'autor'], function() {
        Route::post('/', CreateAutorAction::class)->name('create.autor');

        Route::get('/{codAutor}', GetAutorAction::class)->name('get.autor');

        Route::patch('/{codAutor}', UpdateAutorAction::class)->name('update.autor');

        Route::get('/', ListAutoresAction::class)->name('list.autores');

        Route::delete('/{codAutor}', DeleteAutorAction::class)->name('delete.autor');
    });

    Route::group(['prefix' => 'assunto'], function() {
        Route::post('/', CreateAutorAction::class)->name('create.assunto');

        Route::get('/{codAssunto}', GetAutorAction::class)->name('get.assunto');

        Route::patch('/{codAssunto}', UpdateAutorAction::class)->name('update.assunto');

        Route::get('/', ListAutoresAction::class)->name('list.assuntos');

        Route::delete('/{codAssunto}', DeleteAutorAction::class)->name('delete.assunto');
    });
});
