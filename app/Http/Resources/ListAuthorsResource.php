<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $codAu
 * @property string $nome
 */
class ListAuthorsResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'codAu' => $this->codAu,
            'nome' => $this->nome,
        ];
    }
}
