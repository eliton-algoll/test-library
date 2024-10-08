<?php

namespace App\Domains\Books\DTOs;

final class UpdateLivroDTO
{
    public function __construct(
        private ?string $titulo,
        private ?string $editora,
        private ?string $edicao,
        private ?string $anoPublicacao,
        private ?float $valor,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'Titulo' => $this->titulo,
            'Editora' => $this->editora,
            'Edicao' => $this->edicao,
            'AnoPublicacao' => $this->anoPublicacao,
            'Valor' => $this->valor,
        ], fn ($value) => $value !== null);
    }
}
