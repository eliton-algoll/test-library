<?php

namespace App\Http\Controllers\Web;

use App\Domains\Books\Services\AuthorService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListAuthorsResource;
use Throwable;

class AuthorAction extends Controller
{
    public function __construct(
        protected AuthorService $service,
    ) { }

    public function index()
    {
        try {
            $autors = $this->service->listAll();

            $response = [
                'authors' => ListAuthorsResource::collection($autors)
            ];

            return view('authors/index', $response);
        } catch (Throwable $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }

    }
}
