<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\AuthorDTO;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateAuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function updateAuthor(AuthorDTO $authorDTO, int $codAuthor): Author {
        $this->logger->info(sprintf('[%s] Try Updating a book', __METHOD__), [
            'author_dto' => $authorDTO->toArray(),
            'cod_author' => $codAuthor,
        ]);

        try {
            return $this->authorRepository->update($authorDTO, $codAuthor);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a author', __METHOD__), [
                'author_dto' => $authorDTO->toArray(),
                'cod_author' => $codAuthor,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when update author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update author', __METHOD__), [
                'author_dto' => $authorDTO->toArray(),
                'cod_author' => $codAuthor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
