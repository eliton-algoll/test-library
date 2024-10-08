<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\UpdateLivroDTO;
use App\Domains\Books\Repositories\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateLivroService
{
    public function __construct(
        private readonly LivroRepositoryInterface $livroRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function updateLivro(UpdateLivroDTO $livroDTO, int $codLivro): Livro {
        $this->logger->info(sprintf('[%s] Try Updating a book', __METHOD__), [
            'livro_dto' => $livroDTO->toArray(),
        ]);

        try {
            return $this->livroRepository->update($livroDTO, $codLivro);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a book', __METHOD__), [
                'livro_dto' => $livroDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when update book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update book', __METHOD__), [
                'livro_dto' => $livroDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
