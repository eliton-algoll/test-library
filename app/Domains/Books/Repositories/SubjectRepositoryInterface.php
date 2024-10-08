<?php

namespace App\Domains\Books\Repositories;

use App\Domains\Books\DTOs\SubjectDTO;
use App\Models\Subject;
use Illuminate\Support\Collection;

interface SubjectRepositoryInterface
{
    public function create(SubjectDTO $subjectDTO): Subject;

    public function get(int $codSubject): Subject;

    public function getAll(): Collection;

    public function update(SubjectDTO $subjectDTO, int $codSubject): Subject;

    public function delete(int $codSubject): void;
}
