<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateBookService;
use App\Http\Requests\Books\CreateBookRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CreateBookAction
{
    public function __construct(private readonly CreateBookService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(CreateBookRequest $request): JsonResponse
    {
        try {
            $bookDTO = $request->toDTO();

            $book = $this->service->firstOrCreateByDTO($bookDTO);

            return response()->json($book->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
