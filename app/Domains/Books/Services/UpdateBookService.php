<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\UpdateBookDTO;
use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly BookAuthorRepositoryInterface $bookAuthorRepository,
        private readonly BookSubjectRepositoryInterface $bookSubjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function updateBook(UpdateBookDTO $bookDTO, int $codBook): Book {
        $this->logger->info(sprintf('[%s] Try Updating a book', __METHOD__), [
            'book_dto' => $bookDTO->toArray(),
            'cod_book' => $codBook,
        ]);

        try {
            $this->bookRepository->beginTransaction();

            $book = $this->bookRepository->update($bookDTO, $codBook);

            if ($bookDTO->getCodSubject()) {
                $this->bookSubjectRepository->deleteByCodBook($book->codL);

                $this->bookSubjectRepository->create($book->codL, $bookDTO->getCodSubject());
            }

            if ($bookDTO->getCodAuthors()) {
                $this->bookAuthorRepository->deleteByCodBook($book->codL);

                foreach ($bookDTO->getCodAuthors() as $codAuthor) {
                    $this->bookAuthorRepository->create($book->codL, $codAuthor);
                }
            }

            $this->bookRepository->commit();

            return $book;
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => $codBook,
                'error' => $e->getMessage(),
            ]);

            $this->bookRepository->rollback();

            throw new RuntimeException('Error when update book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => $codBook,
                'error' => $th->getMessage(),
            ]);

            $this->bookRepository->rollback();

            throw $th;
        }
    }
}
