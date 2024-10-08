<?php

namespace App\Domains\Books\Repositories;

use App\Models\BookSubject;

interface BookSubjectRepositoryInterface
{
    public function create(int $codBook, int $codSubject): BookSubject;

    public function delete(int $codBook, int $codSubject): void;
}
