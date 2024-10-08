<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Throwable;

class AuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function findByCode(int $codAuthor): ?Author {
        $this->logger->info(sprintf('[%s] Try Getting a author by code', __METHOD__), [
            'cod_author' => $codAuthor,
        ]);

        try {
            return $this->authorRepository->get($codAuthor);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'cod_author' => $codAuthor,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Author not found');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'cod_author' => $codAuthor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function listAll(): Collection {
        $this->logger->info(sprintf('[%s] Try Getting all authors', __METHOD__));

        return $this->authorRepository->getAll();
    }
}
