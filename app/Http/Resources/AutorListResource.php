<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $CodAu
 * @property string $Nome
 */
class AutorListResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'codAutor' => $this->CodAu,
            'titulo' => $this->Nome,
        ];
    }
}
