<?php

namespace App\Domains\Books\DTOs;

final class AuthorDTO
{
    public function __construct(
        private string $nome,
    ) {}

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
        ];
    }
}
