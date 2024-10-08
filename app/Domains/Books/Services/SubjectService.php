<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Models\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Throwable;

class SubjectService
{
    public function __construct(
        private readonly SubjectRepositoryInterface $subjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function findByCode(int $codSubject): ?Subject {
        $this->logger->info(sprintf('[%s] Try Getting a subject by code', __METHOD__), [
            'cod_subject' => $codSubject,
        ]);

        try {
            return $this->subjectRepository->get($codSubject);
        } catch (ModelNotFoundException $e) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a subject by code', __METHOD__), [
                'cod_subject' => $codSubject,
                'error' => $e->getMessage(),
            ]);

            throw new ModelNotFoundException('Subject not found');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when getting a subject by code', __METHOD__), [
                'cod_subject' => $codSubject,
                'error' => $th->getMessage(),
            ]);

            throw $th;
        }
    }

    public function listAll(): Collection {
        $this->logger->info(sprintf('[%s] Try Getting all subjects', __METHOD__));

        return $this->subjectRepository->getAll();
    }
}
