<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class DeleteBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function deleteBook(int $codBook): void {
        $this->logger->info(sprintf('[%s] Try Deleting a book', __METHOD__), [
            'cod_book' => $codBook,
        ]);

        try {
            $this->bookRepository->delete($codBook);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a book by code', __METHOD__), [
                'code_book' => $codBook,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Book not found');
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when deleting a book', __METHOD__), [
                'cod_book' => $codBook,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when delete book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when deleting book', __METHOD__), [
                'cod_book' => $codBook,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
