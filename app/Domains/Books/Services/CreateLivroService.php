<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\LivroDTO;
use App\Domains\Books\Repositories\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class CreateLivroService
{
    public function __construct(
        private readonly LivroRepositoryInterface $livroRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function firstOrCreateByDTO(LivroDTO $livroDTO): Livro {
        $this->logger->info(sprintf('[%s] Try Creating a new book', __METHOD__), [
            'livro_dto' => $livroDTO->toArray(),
        ]);

        try {
            return $this->livroRepository->create($livroDTO);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when creating a new book', __METHOD__), [
                'livro_dto' => $livroDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when save a new book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when creating a new book', __METHOD__), [
                'livro_dto' => $livroDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
