<?php

namespace App\Domains\Books\Repositories;

use App\Domains\Books\DTOs\LivroDTO;
use App\Domains\Books\DTOs\UpdateLivroDTO;
use App\Models\Livro;
use Illuminate\Pagination\Paginator;

interface LivroRepositoryInterface
{
    public function create(LivroDTO $livroDTO): Livro;

    public function get(int $codLivro): Livro;

    public function getAll(array $filters, array $order, int $itemsPerPage): Paginator;

    public function update(UpdateLivroDTO $updateLivroDTO, int $codLivro): Livro;

    public function delete(int $codeLivro): void;
}
