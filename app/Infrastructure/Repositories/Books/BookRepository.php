<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\DTOs\BookDTO;
use App\Domains\Books\DTOs\UpdateBookDTO;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;

class BookRepository implements BookRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(BookDTO $bookDTO): Book
    {
        $this->logger->info(sprintf('[%s] Creating a new book', __METHOD__), [
            'book_dto' => $bookDTO->toArray(),
        ]);

        /** @var Book $book */
        $book = Book::query()->firstOrCreate($bookDTO->toArray(), $bookDTO->toArray());

        return $book;
    }

    public function get(int $codBook): Book
    {
        $this->logger->info(sprintf('[%s] Getting book by code', __METHOD__), [
            'cod_book' => $codBook,
        ]);

        return Book::query()->where('codL', $codBook)->firstOrFail();
    }

    public function getAll(array $filters, array $order, ?int $itemsPerPage = 20): Paginator
    {
        $this->logger->info(sprintf('[%s] Getting all books', __METHOD__), [
            'filters' => $filters,
            'order' => $order,
            'items_per_page' => $itemsPerPage,
        ]);

        $queryBuilder = Book::query();

        if (!empty($filters)) {
            $titulo = $filters['titulo'];
            $editora = $filters['editora'];
            $edicao = $filters['edicao'];
            $anoPublicacao = $filters['anoPublicacao'];

        $queryBuilder->when($titulo, function(Builder $queryBuilder, string $titulo) {
            $queryBuilder->where(['Titulo' => $titulo]);
        })
            ->when($editora, function(Builder $queryBuilder, string $editora) {
                $queryBuilder->where(['Editora' => $editora]);
            })
            ->when($edicao, function(Builder $queryBuilder, int $edicao) {
                $queryBuilder->where(['Edicao' => $edicao]);
            })
            ->when($anoPublicacao, function(Builder $queryBuilder, string $anoPublicacao) {
                $queryBuilder->where(['AnoPublicacao' => $anoPublicacao]);
            });
        }

        if (!empty($order)) {
            foreach ($order as $orderBy) {
                [$column, $direction] = $orderBy;
                $queryBuilder = $queryBuilder->orderBy($column, $direction);
            }
        }

        return $queryBuilder->simplePaginate($itemsPerPage)->withQueryString();
    }

    public function update(UpdateBookDTO $updateBookDTO, int $codBook): Book
    {
        $this->logger->info(sprintf('[%s] Updating a book', __METHOD__), [
            'update_book_dto' => $updateBookDTO->toArray(),
            'cod_book' => $codBook,
        ]);

        $book = Book::query()->where('codL', $codBook)->firstOrFail();

        $book->update($updateBookDTO->toArray());

        return $book->refresh();
    }

    public function delete(int $codBook): void
    {
        $this->logger->info(sprintf('[%s] Deleting a book', __METHOD__), [
            'cod_book' => $codBook,
        ]);

        $book = Book::query()->where('codL', $codBook)->firstOrFail();

        $book->delete();
    }

    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
