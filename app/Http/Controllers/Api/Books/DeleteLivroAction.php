<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\DeleteLivroService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DeleteLivroAction
{
    public function __construct(private readonly DeleteLivroService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(int $CodLivro)
    {
        try {

            $this->service->deleteLivro($CodLivro);

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
