<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\UpdateLivroService;
use App\Http\Requests\Books\UpdateLivroRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateLivroAction
{
    public function __construct(private readonly UpdateLivroService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpdateLivroRequest $request, int $CodLivro): JsonResponse
    {
        try {
            $livroDTO = $request->toDTO();

            $livro = $this->service->updateLivro($livroDTO, $CodLivro);

            return response()->json($livro->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
