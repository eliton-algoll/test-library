<?php

namespace App\Domains\Books\Repositories;

use App\Domains\Books\DTOs\BookDTO;
use App\Domains\Books\DTOs\UpdateBookDTO;
use App\Models\Book;
use Illuminate\Pagination\Paginator;

interface BookRepositoryInterface
{
    public function create(BookDTO $bookDTO): Book;

    public function get(int $codBook): Book;

    public function getAll(array $filters, array $order, int $itemsPerPage): Paginator;

    public function update(UpdateBookDTO $updateBookDTO, int $codBook): Book;

    public function delete(int $codBook): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
