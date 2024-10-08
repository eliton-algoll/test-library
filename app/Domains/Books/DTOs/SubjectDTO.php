<?php

namespace App\Domains\Books\DTOs;

final class SubjectDTO
{
    public function __construct(
        private string $descricao,
    ) {}

    public function toArray(): array
    {
        return [
            'descricao' => $this->descricao,
        ];
    }
}
