<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\UpdateBookDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'string'],
            'editora' => ['sometimes', 'string'],
            'edicao' => ['sometimes', 'integer'],
            'anoPublicacao' => ['sometimes', 'string'],
            'valor' => ['sometimes', 'numeric'],
            'codAutores' =>  ['sometimes', 'array'],
            'codAutores.*' =>  ['integer'],
            'codAssunto' =>  ['sometimes', 'integer'],
        ];
    }

    public function toDTO(): UpdateBookDTO
    {
        return new UpdateBookDTO(
            titulo: $this->get('titulo'),
            editora: $this->get('editora'),
            edicao: $this->get('edicao'),
            anoPublicacao: $this->get('anoPublicacao'),
            valor: $this->get('valor'),
            codAutores: $this->get('codAutores'),
            codAssunto: $this->get('codAssunto'),
        );
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
