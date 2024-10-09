<?php

namespace App\Domains\Books\DTOs;

final class BookDTO
{
    public function __construct(
        private string $titulo,
        private string $editora,
        private string $edicao,
        private string $anoPublicacao,
        private float $valor,
        private array $codAutores,
        private int $codAssunto,
    ) {}

    public function toArray(): array
    {
        return [
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'edicao' => $this->edicao,
            'anoPublicacao' => $this->anoPublicacao,
            'valor' => $this->valor,
        ];
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
