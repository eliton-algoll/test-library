<?php

use App\Http\Controllers\Api\Books\CreateSubjectAction;
use App\Http\Controllers\Api\Books\CreateAuthorAction;
use App\Http\Controllers\Api\Books\CreateBookAction;
use App\Http\Controllers\Api\Books\DeleteAuthorAction;
use App\Http\Controllers\Api\Books\DeleteBookAction;
use App\Http\Controllers\Api\Books\DeleteSubjectAction;
use App\Http\Controllers\Api\Books\ListSubjectsAction;
use App\Http\Controllers\Api\Books\ShowAuthorAction;
use App\Http\Controllers\Api\Books\ShowBookAction;
use App\Http\Controllers\Api\Books\ListAuthorsAction;
use App\Http\Controllers\Api\Books\ListBooksAction;
use App\Http\Controllers\Api\Books\ShowSubjectAction;
use App\Http\Controllers\Api\Books\UpdateAuthorAction;
use App\Http\Controllers\Api\Books\UpdateBookAction;
use App\Http\Controllers\Api\Books\UpdateSubjectAction;
use Illuminate\Support\Facades\Route;

Route::name('api')->group(function(): void {
    Route::group(['prefix' => 'book'], function() {
        Route::post('/', CreateBookAction::class)->name('create.book');

        Route::get('/{codBook}', ShowBookAction::class)->name('get.book');

        Route::patch('/{codBook}', UpdateBookAction::class)->name('update.book');

        Route::get('/', ListBooksAction::class)->name('list.books');

        Route::delete('/{codBook}', DeleteBookAction::class)->name('delete.book');
    });

    Route::group(['prefix' => 'author'], function() {
        Route::post('/', CreateAuthorAction::class)->name('create.author');

        Route::get('/{codAuthor}', ShowAuthorAction::class)->name('get.author');

        Route::patch('/{codAuthor}', UpdateAuthorAction::class)->name('update.author');

        Route::get('/', ListAuthorsAction::class)->name('list.authors');

        Route::delete('/{codAuthor}', DeleteAuthorAction::class)->name('delete.author');
    });

    Route::group(['prefix' => 'subject'], function() {
        Route::post('/', CreateSubjectAction::class)->name('create.subject');

        Route::get('/{codSubject}', ShowSubjectAction::class)->name('get.subject');

        Route::patch('/{codSubject}', UpdateSubjectAction::class)->name('update.subject');

        Route::get('/', ListSubjectsAction::class)->name('list.subjects');

        Route::delete('/{codSubject}', DeleteSubjectAction::class)->name('delete.subject');
    });
});
