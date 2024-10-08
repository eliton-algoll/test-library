<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\AutorDTO;
use App\Domains\Books\Repositories\AutorRepositoryInterface;
use App\Models\Autor;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateAutorService
{
    public function __construct(
        private readonly AutorRepositoryInterface $autorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function updateAutor(AutorDTO $autorDTO, int $codAutor): Autor {
        $this->logger->info(sprintf('[%s] Try Updating a book', __METHOD__), [
            'autor_dto' => $autorDTO->toArray(),
            'cod_autor' => $codAutor,
        ]);

        try {
            return $this->autorRepository->update($autorDTO, $codAutor);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a author', __METHOD__), [
                'autor_dto' => $autorDTO->toArray(),
                'cod_autor' => $codAutor,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when update author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update author', __METHOD__), [
                'autor_dto' => $autorDTO->toArray(),
                'cod_autor' => $codAutor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
