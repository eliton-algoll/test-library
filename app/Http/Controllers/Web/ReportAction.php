<?php

namespace App\Http\Controllers\Web;

use App\Domains\Books\Services\ReportService;
use App\Http\Controllers\Controller;
use Throwable;

class ReportAction extends Controller
{
    public function __construct(
        protected ReportService $service,
    ) { }

    public function index()
    {
        $pdf = $this->service->generateReport();

        return $pdf->download('relatorio_livros.pdf');
    }
}
