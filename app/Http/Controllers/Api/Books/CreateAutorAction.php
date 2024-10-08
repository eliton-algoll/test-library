<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateAutorService;
use App\Http\Requests\Books\UpsertAutorRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CreateAutorAction
{
    public function __construct(private readonly CreateAutorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertAutorRequest $request): JsonResponse
    {
        try {
            $autorDTO = $request->toDTO();

            $autor = $this->service->firstOrCreateByDTO($autorDTO);

            return response()->json($autor->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
