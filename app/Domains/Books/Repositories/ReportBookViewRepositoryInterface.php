<?php

namespace App\Domains\Books\Repositories;

use Illuminate\Support\Collection;

interface ReportBookViewRepositoryInterface
{
    public function getAll(): Collection;
}
