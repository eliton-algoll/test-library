<?php

namespace App\Domains\Books\DTOs;

final class AutorDTO
{
    public function __construct(
        private string $nome,
    ) {}

    public function toArray(): array
    {
        return [
            'Nome' => $this->nome,
        ];
    }
}
