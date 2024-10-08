<?php

namespace App\Http\Requests\Books;

use App\Domains\Books\DTOs\SubjectDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpsertSubjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string', 'max:20'],
        ];
    }

    public function toDTO(): SubjectDTO
    {
        return new SubjectDTO(
            descricao: $this->get('descricao'),
        );
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
