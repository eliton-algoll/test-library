<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\DTOs\AutorDTO;
use App\Domains\Books\Repositories\AutorRepositoryInterface;
use App\Models\Autor;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class AutorRepository implements AutorRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(AutorDTO $autorDTO): Autor
    {
        $this->logger->info(sprintf('[%s] Creating a new author', __METHOD__), [
            'author_dto' => $autorDTO->toArray(),
        ]);

        /** @var Autor $livro */
        $autor = Autor::query()->firstOrCreate($autorDTO->toArray(), $autorDTO->toArray());

        return $autor;
    }

    public function get(int $codAutor): Autor
    {
        $this->logger->info(sprintf('[%s] Getting author by code', __METHOD__), [
            'cod_autor' => $codAutor,
        ]);

        return Autor::query()->where('CodAu', $codAutor)->firstOrFail();
    }

    public function getAll(): Collection
    {
        $this->logger->info(sprintf('[%s] Getting all authors', __METHOD__));

        return Autor::all();
    }

    public function update(AutorDTO $autorDTO, int $codAutor): Autor
    {
        $this->logger->info(sprintf('[%s] Updating a author', __METHOD__), [
            'autor_dto' => $autorDTO->toArray(),
            'cod_autor' => $codAutor,
        ]);

        $autor = Autor::query()->where('CodAu', $codAutor)->firstOrFail();

        $autor->update($autorDTO->toArray());

        return $autor->refresh();
    }

    public function delete(int $codAutor): void
    {
        $this->logger->info(sprintf('[%s] Deleting a author', __METHOD__), [
            'cod_autor' => $codAutor,
        ]);

        $autor = Autor::query()->where('CodAu', $codAutor)->firstOrFail();

        $autor->delete();
    }
}
