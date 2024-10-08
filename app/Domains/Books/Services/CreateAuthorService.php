<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\AuthorDTO;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class CreateAuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function firstOrCreateByDTO(AuthorDTO $authorDTO): Author {
        $this->logger->info(sprintf('[%s] Try Creating a new author', __METHOD__), [
            'author_dto' => $authorDTO->toArray(),
        ]);

        try {
            return $this->authorRepository->create($authorDTO);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when creating a new author', __METHOD__), [
                'author_dto' => $authorDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when save a new author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when creating a new author', __METHOD__), [
                'author_dto' => $authorDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
