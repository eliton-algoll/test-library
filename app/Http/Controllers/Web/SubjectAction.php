<?php

namespace App\Http\Controllers\Web;

use App\Domains\Books\Services\SubjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListSubjectResource;
use Throwable;

class SubjectAction extends Controller
{
    public function __construct(
        protected SubjectService $service,
    ) { }

    public function index()
    {
        try {
            $subjects = $this->service->listAll();

            $response = [
                'subjects' => ListSubjectResource::collection($subjects)
            ];

            return view('subjects/index', $response);
        } catch (Throwable $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }
}
