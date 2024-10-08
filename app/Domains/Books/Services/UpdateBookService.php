<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\UpdateBookDTO;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
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
            return $this->bookRepository->update($bookDTO, $codBook);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => $codBook,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when update book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => $codBook,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
