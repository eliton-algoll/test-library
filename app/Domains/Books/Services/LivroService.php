<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use Psr\Log\LoggerInterface;
use Throwable;

class LivroService
{
    public function __construct(
        private readonly LivroRepositoryInterface $livroRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function findByCode(int $codLivro): ?Livro {
        $this->logger->info(sprintf('[%s] Try Getting a book by code', __METHOD__), [
            'code_livro' => $codLivro,
        ]);

        try {
            return $this->livroRepository->get($codLivro);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a book by code', __METHOD__), [
                'code_livro' => $codLivro,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Book not found');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a book by code', __METHOD__), [
                'code_livro' => $codLivro,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function listAll(array $filters, array $order, int $itemsPerPage): Paginator {
        $this->logger->info(sprintf('[%s] Try Getting all books', __METHOD__));

        return $this->livroRepository->getAll($filters, $order, $itemsPerPage);
    }
}
