<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\AssuntoDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpsertAssuntoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string', 'max:20'],
        ];
    }

    public function toDTO(): AssuntoDTO
    {
        return new AssuntoDTO(
            descricao: $this->get('descricao'),
        );
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
