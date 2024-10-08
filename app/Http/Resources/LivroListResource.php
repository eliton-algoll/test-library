<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;

class LivroListResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'codLivro' => $this['CodL'],
            'titulo' => $this['Titulo'],
            'editora' => $this['Editora'],
            'edicao' => $this['Edicao'],
            'anoPublicacao' => $this['AnoPublicacao'],
            'valor' => $this['Valor'],
        ];
    }

    public static function items(Paginator $listPaginated): array
    {
        return self::collection($listPaginated)->toArray(request());
    }
}
