<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\SubjectService;
use App\Http\Resources\ListSubjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListSubjectsAction
{
    public function __construct(private readonly SubjectService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $subjects = $this->service->listAll();

        return response()->json([
            'results' => ListSubjectResource::collection($subjects),
        ], Response::HTTP_OK);
    }

}
