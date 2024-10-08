<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class DeleteAutorService
{
    public function __construct(
        private readonly AutorRepositoryInterface $autorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function deleteAutor(int $codAutor): void {
        $this->logger->info(sprintf('[%s] Try Deleting a author', __METHOD__), [
            'cod_autor' => $codAutor,
        ]);

        try {
            $this->autorRepository->delete($codAutor);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'cod_autor' => $codAutor,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Author not found');
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when deleting a author', __METHOD__), [
                'cod_autor' => $codAutor,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when delete author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when deleting author', __METHOD__), [
                'cod_autor' => $codAutor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
