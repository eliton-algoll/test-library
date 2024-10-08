<?php

namespace App\Infrastructure\Repositories\Books;

use App\Domains\Books\DTOs\SubjectDTO;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function create(SubjectDTO $subjectDTO): Subject
    {
        $this->logger->info(sprintf('[%s] Creating a new subject', __METHOD__), [
            'subject_dto' => $subjectDTO->toArray(),
        ]);

        /** @var Subject $subject */
        $subject = Subject::query()->firstOrCreate($subjectDTO->toArray(), $subjectDTO->toArray());

        return $subject;
    }

    public function get(int $codSubject): Subject
    {
        $this->logger->info(sprintf('[%s] Getting subject by code', __METHOD__), [
            'cod_subject' => $codSubject,
        ]);

        return Subject::query()->where('CodAs', $codSubject)->firstOrFail();
    }

    public function getAll(): Collection
    {
        $this->logger->info(sprintf('[%s] Getting all subjects', __METHOD__));

        return Subject::all();
    }

    public function update(SubjectDTO $subjectDTO, int $codSubject): Subject
    {
        $this->logger->info(sprintf('[%s] Updating a author', __METHOD__), [
            'subject_dto' => $subjectDTO->toArray(),
            'cod_subject' => $codSubject,
        ]);

        $subject = Subject::query()->where('codAs', $codSubject)->firstOrFail();

        $subject->update($subjectDTO->toArray());

        return $subject->refresh();
    }

    public function delete(int $codSubject): void
    {
        $this->logger->info(sprintf('[%s] Deleting a subject', __METHOD__), [
            'cod_subject' => $codSubject,
        ]);

        $subject = Subject::query()->where('codAs', $codSubject)->firstOrFail();

        $subject->delete();
    }
}
