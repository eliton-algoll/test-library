<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $codAs
 * @property string $descricao
 */
class ListSubjectResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'codAs' => $this->codAs,
            'descricao' => $this->descricao,
        ];
    }
}
