<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\AutorDTO;
use App\Domains\Books\Repositories\AutorRepositoryInterface;
use App\Models\Autor;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class CreateAutorService
{
    public function __construct(
        private readonly AutorRepositoryInterface $autorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function firstOrCreateByDTO(AutorDTO $autorDTO): Autor {
        $this->logger->info(sprintf('[%s] Try Creating a new author', __METHOD__), [
            'autor_dto' => $autorDTO->toArray(),
        ]);

        try {
            return $this->autorRepository->create($autorDTO);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when creating a new author', __METHOD__), [
                'autor_dto' => $autorDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when save a new author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when creating a new author', __METHOD__), [
                'autor_dto' => $autorDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
