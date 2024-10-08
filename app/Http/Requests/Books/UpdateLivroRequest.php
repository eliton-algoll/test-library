<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\LivroDTO;
use App\Domains\Books\DTOs\UpdateLivroDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateLivroRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'string'],
            'editora' => ['sometimes', 'string'],
            'edicao' => ['sometimes', 'integer'],
            'anoPublicacao' => ['sometimes', 'string'],
            'valor' => ['sometimes', 'numeric', 'gt:0.0'],
        ];
    }

    public function toDTO(): UpdateLivroDTO
    {
        return new UpdateLivroDTO(
            titulo: $this->get('titulo'),
            editora: $this->get('editora'),
            edicao: $this->get('edicao'),
            anoPublicacao: $this->get('anoPublicacao'),
            valor: $this->get('valor'),
        );
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
