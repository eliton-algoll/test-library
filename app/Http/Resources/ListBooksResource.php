<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;

class ListBooksResource extends JsonResource
{
    public function toArray($request): array {
        $subjectResource = ListSubjectResource::collection($this->whenLoaded('subjects'));

        return [
            'codL' => $this->codL,
            'titulo' => $this->titulo,
            'editora' => $this->editora,
            'edicao' => $this->edicao,
            'anoPublicacao' => $this->anoPublicacao,
            'valor' => $this->valor,
            'autores' => ListAuthorsResource::collection($this->whenLoaded('authors')),
            'assunto' => $subjectResource[0],
        ];
    }

    public static function items(Paginator $listPaginated): array
    {
        return self::collection($listPaginated)->toArray(request());
    }
}
