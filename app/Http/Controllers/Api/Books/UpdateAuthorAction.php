<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\UpdateAuthorService;
use App\Http\Requests\Books\UpsertAuthorRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateAuthorAction
{
    public function __construct(private readonly UpdateAuthorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertAuthorRequest $request, int $codAuthor): JsonResponse
    {
        try {
            $authorDTO = $request->toDTO();

            $author = $this->service->updateAuthor($authorDTO, $codAuthor);

            return response()->json($author->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
