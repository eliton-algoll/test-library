<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class DeleteAuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function deleteAuthor(int $codAuthor): void {
        $this->logger->info(sprintf('[%s] Try Deleting a author', __METHOD__), [
            'cod_author' => $codAuthor,
        ]);

        try {
            $this->authorRepository->delete($codAuthor);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a author by code', __METHOD__), [
                'cod_author' => $codAuthor,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Author not found');
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when deleting a author', __METHOD__), [
                'cod_author' => $codAuthor,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when delete author in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when deleting author', __METHOD__), [
                'cod_author' => $codAuthor,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
