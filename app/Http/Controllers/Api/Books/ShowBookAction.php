<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ShowBookAction
{
    public function __construct(private readonly BookService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(int $codBook): JsonResponse
    {
        try {

            $book = $this->service->findByCode($codBook);

            return response()->json($book->toArray());
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
