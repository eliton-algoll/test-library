<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Models\BookAuthor;
use Psr\Log\LoggerInterface;

class BookAuthorRepository implements BookAuthorRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(int $codBook, int $codAuthor): BookAuthor
    {
        $this->logger->info(sprintf('[%s] Creating a new book author', __METHOD__), [
            'cod_book' => $codBook,
            'cod_author' => $codAuthor,
        ]);

        $payload = [
            'livro_codL' => $codBook,
            'autor_codAu' => $codAuthor,
        ];

        /** @var BookAuthor $bookAuthor */
        $bookAuthor = BookAuthor::query()->firstOrCreate($payload, $payload);

        return $bookAuthor;
    }

    public function delete(int $codBook, int $codAuthor): void
    {
        $this->logger->info(sprintf('[%s] Deleting book author', __METHOD__), [
            'cod_book' => $codBook,
            'cod_author' => $codAuthor,
        ]);

        $bookAuthor = BookAuthor::query()
            ->where('livro_codL', $codBook)
            ->where('autor_codAu', $codAuthor)
            ->firstOrFail();

        $bookAuthor->delete();
    }

    public function deleteByCodBook(int $codBook): void
    {
        $this->logger->info(sprintf('[%s] Deleting book author by book code', __METHOD__), [
            'cod_book' => $codBook,
        ]);

        BookAuthor::query()
            ->where('livro_codL', $codBook)
            ->delete();
    }
}
