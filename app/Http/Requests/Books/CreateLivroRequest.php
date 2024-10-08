<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\LivroDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreateLivroRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:40'],
            'editora' => ['required', 'string', 'max:40'],
            'edicao' => ['required', 'integer'],
            'anoPublicacao' => ['required', 'string', 'max:4'],
            'valor' => ['required', 'numeric'],
        ];
    }

    public function toDTO(): LivroDTO
    {
        return new LivroDTO(
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
