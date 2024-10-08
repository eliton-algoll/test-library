<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\UpdateBookService;
use App\Http\Requests\Books\UpdateBookRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateBookAction
{
    public function __construct(private readonly UpdateBookService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpdateBookRequest $request, int $codBook): JsonResponse
    {
        try {
            $bookDTO = $request->toDTO();

            $book = $this->service->updateBook($bookDTO, $codBook);

            return response()->json($book->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
