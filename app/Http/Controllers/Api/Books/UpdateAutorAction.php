<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\UpdateAutorService;
use App\Http\Requests\Books\UpsertAutorRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateAutorAction
{
    public function __construct(private readonly UpdateAutorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertAutorRequest $request, int $codAutor): JsonResponse
    {
        try {
            $autorDTO = $request->toDTO();

            $autor = $this->service->updateAutor($autorDTO, $codAutor);

            return response()->json($autor->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
