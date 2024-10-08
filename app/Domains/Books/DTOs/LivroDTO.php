<?php

namespace App\Domains\Books\DTOs;

final class LivroDTO
{
    public function __construct(
        private string $titulo,
        private string $editora,
        private string $edicao,
        private string $anoPublicacao,
        private float $valor,
    ) {}

    public function toArray(): array
    {
        return [
            'Titulo' => $this->titulo,
            'Editora' => $this->editora,
            'Edicao' => $this->edicao,
            'AnoPublicacao' => $this->anoPublicacao,
            'Valor' => $this->valor,
        ];
    }
}
