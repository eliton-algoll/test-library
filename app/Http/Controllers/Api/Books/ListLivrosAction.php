<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\CreateLivroService;
use App\Domains\Books\Services\LivroService;
use App\Http\Requests\Books\CreateLivroRequest;
use App\Http\Resources\LivroListResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListLivrosAction
{
    public function __construct(private readonly LivroService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $order = $request->get('order', []);
        $itemsPerPage = $request->get('itemsPerPage', 20);
        $filters = $request->except(['itemsPerPage', 'order']);

        $livros = $this->service->listAll($filters, $order, $itemsPerPage);

        return response()->json([
            'results' => LivroListResource::items($livros),
            'next' => $livros->nextPageUrl(),
            'previous' => $livros->previousPageUrl(),
            'page' => $livros->currentPage(),
            'count' => $itemsPerPage,
        ], Response::HTTP_OK);
    }

}
