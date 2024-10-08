<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\AutorService;
use App\Http\Resources\AutorListResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListAutoresAction
{
    public function __construct(private readonly AutorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $autores = $this->service->listAll();

        return response()->json([
            'results' => AutorListResource::collection($autores),
        ], Response::HTTP_OK);
    }

}
