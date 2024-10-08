<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\DeleteAutorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DeleteAutorAction
{
    public function __construct(private readonly DeleteAutorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(int $codAutor): JsonResponse
    {
        try {

            $this->service->deleteAutor($codAutor);

            return response()->json([], Response::HTTP_NO_CONTENT);
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
