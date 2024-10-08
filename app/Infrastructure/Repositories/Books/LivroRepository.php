<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\DTOs\LivroDTO;
use App\Domains\Books\DTOs\UpdateLivroDTO;
use App\Domains\Books\Repositories\LivroRepositoryInterface;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Psr\Log\LoggerInterface;

class LivroRepository implements LivroRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(LivroDTO $livroDTO): Livro
    {
        $this->logger->info(sprintf('[%s] Creating a new book', __METHOD__), [
            'livro_dto' => $livroDTO->toArray(),
        ]);

        /** @var Livro $livro */
        $livro = Livro::query()->firstOrCreate($livroDTO->toArray(), $livroDTO->toArray());

        return $livro;
    }

    public function get(int $codLivro): Livro
    {
        $this->logger->info(sprintf('[%s] Getting book by code', __METHOD__), [
            'cod_livro' => $codLivro,
        ]);

        return Livro::query()->where('CodL', $codLivro)->firstOrFail();
    }

    public function getAll(array $filters, array $order, ?int $itemsPerPage = 20): Paginator
    {
        $this->logger->info(sprintf('[%s] Getting all books', __METHOD__), [
            'filters' => $filters,
            'order' => $order,
            'items_per_page' => $itemsPerPage,
        ]);

        $queryBuilder = Livro::query();

        if (!empty($filters)) {
            $titulo = $filters['titulo'];
            $editora = $filters['editora'];
            $edicao = $filters['edicao'];
            $anoPublicacao = $filters['anoPublicacao'];

        $queryBuilder->when($titulo, function(Builder $queryBuilder, string $titulo) {
            $queryBuilder->where(['Titulo' => $titulo]);
        })
            ->when($editora, function(Builder $queryBuilder, string $editora) {
                $queryBuilder->where(['Editora' => $editora]);
            })
            ->when($edicao, function(Builder $queryBuilder, int $edicao) {
                $queryBuilder->where(['Edicao' => $edicao]);
            })
            ->when($anoPublicacao, function(Builder $queryBuilder, string $anoPublicacao) {
                $queryBuilder->where(['AnoPublicacao' => $anoPublicacao]);
            });
        }

        if (!empty($order)) {
            foreach ($order as $orderBy) {
                [$column, $direction] = $orderBy;
                $queryBuilder = $queryBuilder->orderBy($column, $direction);
            }
        }

        return $queryBuilder->simplePaginate($itemsPerPage)->withQueryString();
    }

    public function update(UpdateLivroDTO $updateLivroDTO, int $codLivro): Livro
    {
        $this->logger->info(sprintf('[%s] Updating a book', __METHOD__), [
            'update_livro_dto' => $updateLivroDTO->toArray(),
            'cod_livro' => $codLivro,
        ]);

        $livro = Livro::query()->where('CodL', $codLivro)->firstOrFail();

        $livro->update($updateLivroDTO->toArray());

        return $livro->refresh();
    }

    public function delete(int $codeLivro): void
    {
        $this->logger->info(sprintf('[%s] Deleting a book', __METHOD__), [
            'cod_livro' => $codeLivro,
        ]);

        $livro = Livro::query()->where('CodL', $codeLivro)->firstOrFail();

        $livro->delete();
    }
}
