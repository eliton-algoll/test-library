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
        private array $autores,
        private array $assuntos,
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

    public function getSubjects(): array
    {
        return $this->assuntos;
    }

    public function getAuthors(): array
    {
        return $this->autores;
    }
}
