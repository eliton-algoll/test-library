<?php

namespace App\Http\Controllers\Api\Books;

use App\Domains\Books\Services\BookService;
use App\Http\Resources\ListBooksResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListBooksAction
{
    public function __construct(private readonly BookService $service)
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $order = $request->get('order', []);
        $itemsPerPage = $request->get('itemsPerPage', 20);
        $filters = $request->except(['itemsPerPage', 'order']);

        $books = $this->service->listAll($filters, $order, $itemsPerPage);

        return response()->json([
            'results' => ListBooksResource::items($books),
            'next' => $books->nextPageUrl(),
            'previous' => $books->previousPageUrl(),
            'page' => $books->currentPage(),
            'count' => $itemsPerPage,
        ], Response::HTTP_OK);
    }

}
