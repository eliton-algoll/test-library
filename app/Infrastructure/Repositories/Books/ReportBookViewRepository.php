<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\Repositories\ReportBookViewRepositoryInterface;
use App\Models\ReportBookView;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class ReportBookViewRepository implements ReportBookViewRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function getAll(): Collection
    {
        $this->logger->info(sprintf('[%s] Getting all report data', __METHOD__));

        return ReportBookView::all();
    }
}
