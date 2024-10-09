<?php

namespace App\Domains\Books\DTOs;

final class UpdateBookDTO
{
    public function __construct(
        private ?string $titulo,
        private ?string $editora,
        private ?string $edicao,
        private ?string $anoPublicacao,
        private ?float $valor,
        private ?array $codAutores,
        private ?int $codAssunto,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'edicao' => $this->edicao,
            'anoPublicacao' => $this->anoPublicacao,
            'valor' => $this->valor,
        ], fn ($value) => $value !== null);
    }

    public function getCodSubject(): int
    {
        return $this->codAssunto;
    }

    public function getCodAuthors(): array
    {
        return $this->codAutores;
    }
}
