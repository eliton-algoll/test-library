<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\SubjectDTO;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class CreateSubjectService
{
    public function __construct(
        private readonly SubjectRepositoryInterface $subjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function firstOrCreateByDTO(SubjectDTO $subjectDTO): Subject {
        $this->logger->info(sprintf('[%s] Try Creating a new subject', __METHOD__), [
            'subject_dto' => $subjectDTO->toArray(),
        ]);

        try {
            return $this->subjectRepository->create($subjectDTO);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when creating a new subject', __METHOD__), [
                'subject_dto' => $subjectDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when save a new subject in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when creating a new subject', __METHOD__), [
                'subject_dto' => $subjectDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
