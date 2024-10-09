<?php

use App\Http\Controllers\Web\AuthorAction;
use App\Http\Controllers\Web\BookAction;
use App\Http\Controllers\Web\SubjectAction;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookAction::class, 'index'])->name('books.index');

Route::get('/authors', [AuthorAction::class, 'index'])->name('authors.index');

Route::get('/subjects', [SubjectAction::class, 'index'])->name('subjects.index');
