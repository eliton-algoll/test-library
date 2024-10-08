<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use Psr\Log\LoggerInterface;

class BookSubjectRepository implements BookSubjectRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(int $codBook, int $codSubject): BookSubject
    {
        $this->logger->info(sprintf('[%s] Creating a new book subject', __METHOD__), [
            'cod_book' => $codBook,
            'cod_subject' => $codSubject,
        ]);

        $payload = [
            'livro_codL' => $codBook,
            'assunto_codAs' => $codSubject,
        ];

        /** @var BookSubject $bookSubject */
        $bookSubject = BookSubject::query()->firstOrCreate($payload, $payload);

        return $bookSubject;
    }

    public function delete(int $codBook, int $codSubject): void
    {
        $this->logger->info(sprintf('[%s] Deleting book subject', __METHOD__), [
            'cod_book' => $codBook,
            'cod_subject' => $codSubject,
        ]);

        $bookAuthor = BookAuthor::query()
            ->where('livro_codL', $codBook)
            ->where('assunto_codAs', $codSubject)
            ->firstOrFail();

        $bookAuthor->delete();
    }
}
