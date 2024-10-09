<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\BookDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:40'],
            'editora' => ['required', 'string', 'max:40'],
            'edicao' => ['required', 'integer'],
            'anoPublicacao' => ['required', 'string', 'max:4'],
            'valor' => ['required', 'numeric'],
            'codAutores' =>  ['required', 'array'],
            'codAutores.*' =>  ['integer'],
            'codAssunto' =>  ['required', 'integer'],
        ];
    }

    public function toDTO(): BookDTO
    {
        return new BookDTO(
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
