<?php

namespace App\Domains\Books\Repositories;

use App\Models\BookAuthor;

interface BookAuthorRepositoryInterface
{
    public function create(int $codBook, int $codAuthor): BookAuthor;

    public function delete(int $codBook, int $codAuthor): void;
}
