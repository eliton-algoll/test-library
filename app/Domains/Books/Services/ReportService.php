<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\ReportBookViewRepositoryInterface;
use Psr\Log\LoggerInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PDFFile;

class ReportService
{
    public function __construct(
        private readonly ReportBookViewRepositoryInterface $reportBookViewRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    public function generateReport(): PDFFile
    {
        $this->logger->info(sprintf('[%s] Generating report', __METHOD__));

        $reportData = $this->reportBookViewRepository->getAll();

        return Pdf::loadView('reports.reportBook', compact('reportData'));
    }
}
