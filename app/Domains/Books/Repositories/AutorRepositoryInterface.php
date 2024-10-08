<?php

namespace App\Domains\Books\Repositories;

use App\Domains\Books\DTOs\AutorDTO;
use App\Models\Autor;
use Illuminate\Support\Collection;

interface AutorRepositoryInterface
{
    public function create(AutorDTO $autorDTO): Autor;

    public function get(int $codAutor): Autor;

    public function getAll(): Collection;

    public function update(AutorDTO $autorDTO, int $codAutor): Autor;

    public function delete(int $codAutor): void;
}
