<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\SubjectDTO;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class UpdateSubjectService
{
    public function __construct(
        private readonly SubjectRepositoryInterface $subjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function updateSubject(SubjectDTO $subjectDTO, int $codSubject): Subject {
        $this->logger->info(sprintf('[%s] Try Updating a book', __METHOD__), [
            'subject_dto' => $subjectDTO->toArray(),
            'cod_subject' => $codSubject,
        ]);

        try {
            return $this->subjectRepository->update($subjectDTO, $codSubject);
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when updating a subject', __METHOD__), [
                'subject_dto' => $subjectDTO->toArray(),
                'cod_subject' => $codSubject,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when update subject in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when update subject', __METHOD__), [
                'subject_dto' => $subjectDTO->toArray(),
                'cod_subject' => $codSubject,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
