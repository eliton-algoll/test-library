<?php

namespace App\Http\Controllers\Web;

use App\Domains\Books\Services\AuthorService;
use App\Domains\Books\Services\BookService;
use App\Domains\Books\Services\SubjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListAuthorsResource;
use App\Http\Resources\ListBooksResource;
use App\Http\Resources\ListSubjectResource;
use Illuminate\Http\Request;
use Throwable;

class BookAction extends Controller
{
    public function __construct(
        protected BookService $service,
        protected AuthorService $authorService,
        protected SubjectService $subjectService,
    ) { }

    public function index(Request $request)
    {
        try {
            $order = $request->get('order', []);
            $itemsPerPage = $request->get('itemsPerPage', 20);
            $filters = $request->except(['itemsPerPage', 'order']);

            $books = $this->service->listAll($filters, $order, $itemsPerPage);

            $authors = $this->authorService->listAll();
            $subjects = $this->subjectService->listAll();

            $response = [
                'results' => ListBooksResource::items($books),
                'authors' => ListAuthorsResource::collection($authors),
                'subjects' => ListSubjectResource::collection($subjects),
                'next' => $books->nextPageUrl(),
                'previous' => $books->previousPageUrl(),
                'page' => $books->currentPage(),
                'count' => $itemsPerPage,
            ];

            return view('books/index', $response);
        } catch (Throwable $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }

    }
}
