<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class DeleteSubjectService
{
    public function __construct(
        private readonly SubjectRepositoryInterface $subjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function deleteSubject(int $codSubject): void {
        $this->logger->info(sprintf('[%s] Try Deleting a subject', __METHOD__), [
            'cod_subject' => $codSubject,
        ]);

        try {
            $this->subjectRepository->delete($codSubject);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a subject by code', __METHOD__), [
                'cod_subject' => $codSubject,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Subject not found');
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when deleting a subject', __METHOD__), [
                'cod_subject' => $codSubject,
                'error' => $e->getMessage(),
            ]);

            throw new RuntimeException('Error when delete subject in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when deleting subject', __METHOD__), [
                'cod_subject' => $codSubject,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }
}
