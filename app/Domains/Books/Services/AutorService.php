<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\AutorRepositoryInterface;
use App\Models\Autor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Throwable;

class AutorService
{
    public function __construct(
        private readonly AutorRepositoryInterface $autorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function findByCode(int $codAutor): ?Autor {
        $this->logger->info(sprintf('[%s] Try Getting a author by code', __METHOD__), [
            'cod_autor' => $codAutor,
        ]);

        try {
            return $this->autorRepository->get($codAutor);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'code_livro' => $codAutor,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Author not found');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'cod_autor' => $codAutor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function listAll(): Collection {
        $this->logger->info(sprintf('[%s] Try Getting all authors', __METHOD__));

        return $this->autorRepository->getAll();
    }
}
