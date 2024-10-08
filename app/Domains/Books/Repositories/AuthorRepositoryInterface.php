<?php

namespace App\Domains\Books\Repositories;

use App\Domains\Books\DTOs\AuthorDTO;
use App\Models\Author;
use Illuminate\Support\Collection;

interface AuthorRepositoryInterface
{
    public function create(AuthorDTO $authorDTO): Author;

    public function get(int $codAuthor): Author;

    public function getAll(): Collection;

    public function update(AuthorDTO $authorDTO, int $codAuthor): Author;

    public function delete(int $codAuthor): void;
}
