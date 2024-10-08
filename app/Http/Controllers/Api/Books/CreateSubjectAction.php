<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateSubjectService;
use App\Http\Requests\Books\UpsertSubjectRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CreateSubjectAction
{
    public function __construct(private readonly CreateSubjectService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertSubjectRequest $request): JsonResponse
    {
        try {
            $subjectDTO = $request->toDTO();

            $subject = $this->service->firstOrCreateByDTO($subjectDTO);

            return response()->json($subject->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
