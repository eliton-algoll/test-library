<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\AuthorService;
use App\Http\Resources\ListAuthorsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListAuthorsAction
{
    public function __construct(private readonly AuthorService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $authors = $this->service->listAll();

        return response()->json([
            'results' => ListAuthorsResource::collection($authors),
        ], Response::HTTP_OK);
    }

}
