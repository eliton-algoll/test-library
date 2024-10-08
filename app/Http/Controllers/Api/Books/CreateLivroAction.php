<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateLivroService;
use App\Http\Requests\Books\CreateLivroRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CreateLivroAction
{
    public function __construct(private readonly CreateLivroService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(CreateLivroRequest $request)
    {
        try {
            $livroDTO = $request->toDTO();

            $livro = $this->service->firstOrCreateByDTO($livroDTO);

            return response()->json($livro->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
