<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\UpdateSubjectService;
use App\Http\Requests\Books\UpsertSubjectRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateSubjectAction
{
    public function __construct(private readonly UpdateSubjectService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(UpsertSubjectRequest $request, int $codSubject): JsonResponse
    {
        try {
            $subjectDTO = $request->toDTO();

            $subject = $this->service->updateSubject($subjectDTO, $codSubject);

            return response()->json($subject->toArray());
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
