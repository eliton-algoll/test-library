<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateLivroService;
use App\Domains\Books\Services\LivroService;
use App\Http\Requests\Books\CreateLivroRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GetLivroAction
{
    public function __construct(private readonly LivroService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(int $CodLivro)
    {
        try {

            $livro = $this->service->findByCode($CodLivro);

            return response()->json($livro->toArray());
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
