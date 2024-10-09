<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use Psr\Log\LoggerInterface;
use Throwable;

class BookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function findByCode(int $codBook): ?Book {
        $this->logger->info(sprintf('[%s] Try Getting a book by code', __METHOD__), [
            'code_book' => $codBook,
        ]);

        try {
            return $this->bookRepository->get($codBook);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a book by code', __METHOD__), [
                'code_book' => $codBook,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Book not found');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a book by code', __METHOD__), [
                'code_book' => $codBook,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function listAll(array $filters, array $order, int $itemsPerPage): Paginator {
        $this->logger->info(sprintf('[%s] Try Getting all books', __METHOD__));

        try {
            return $this->bookRepository->getAll($filters, $order, $itemsPerPage);
        } catch (Throwable $th){
            dd($th->getMessage());
        }

    }
}
