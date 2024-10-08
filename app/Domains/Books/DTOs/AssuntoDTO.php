<?php

namespace App\Domains\Books\DTOs;

final class AssuntoDTO
{
    public function __construct(
        private string $descricao,
    ) {}

    public function toArray(): array
    {
        return [
            'Descricao' => $this->descricao,
        ];
    }
}
