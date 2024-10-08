<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\DTOs\AuthorDTO;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(AuthorDTO $authorDTO): Author
    {
        $this->logger->info(sprintf('[%s] Creating a new author', __METHOD__), [
            'author_dto' => $authorDTO->toArray(),
        ]);

        /** @var Author $author */
        $author = Author::query()->firstOrCreate($authorDTO->toArray(), $authorDTO->toArray());

        return $author;
    }

    public function get(int $codAuthor): Author
    {
        $this->logger->info(sprintf('[%s] Getting author by code', __METHOD__), [
            'cod_author' => $codAuthor,
        ]);

        return Author::query()->where('codAu', $codAuthor)->firstOrFail();
    }

    public function getAll(): Collection
    {
        $this->logger->info(sprintf('[%s] Getting all authors', __METHOD__));

        return Author::all();
    }

    public function update(AuthorDTO $authorDTO, int $codAuthor): Author
    {
        $this->logger->info(sprintf('[%s] Updating a author', __METHOD__), [
            'author_dto' => $authorDTO->toArray(),
            'cod_author' => $codAuthor,
        ]);

        $author = Author::query()->where('codAu', $codAuthor)->firstOrFail();

        $author->update($authorDTO->toArray());

        return $author->refresh();
    }

    public function delete(int $codAuthor): void
    {
        $this->logger->info(sprintf('[%s] Deleting a author', __METHOD__), [
            'cod_author' => $codAuthor,
        ]);

        $author = Author::query()->where('codAu', $codAuthor)->firstOrFail();

        $author->delete();
    }
}
