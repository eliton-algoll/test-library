<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateAuthorService;
use App\Http\Requests\Books\UpsertAuthorRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CreateAuthorAction
{
    public function __construct(private readonly CreateAuthorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertAuthorRequest $request): JsonResponse
    {
        try {
            $authorDTO = $request->toDTO();

            $author = $this->service->firstOrCreateByDTO($authorDTO);

            return response()->json($author->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
