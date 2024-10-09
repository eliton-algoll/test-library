<?php

namespace App\Domains\Books\Services;

use App\Domains\Books\DTOs\AuthorDTO;
use App\Domains\Books\DTOs\BookDTO;
use App\Domains\Books\DTOs\SubjectDTO;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\QueryException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

class CreateBookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly BookAuthorRepositoryInterface $bookAuthorRepository,
        private readonly SubjectRepositoryInterface $subjectRepository,
        private readonly BookSubjectRepositoryInterface $bookSubjectRepository,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws Throwable
     */
    public function firstOrCreateByDTO(BookDTO $bookDTO): Book {
        $this->logger->info(sprintf('[%s] Try Creating a new book', __METHOD__), [
            'book_dto' => $bookDTO->toArray(),
        ]);

        try {
            $this->bookRepository->beginTransaction();

            $book = $this->bookRepository->create($bookDTO);

            foreach($bookDTO->getCodAuthors() as $codAuthor) {
                $authorSaved = $this->authorRepository->get($codAuthor);

                $this->bookAuthorRepository->create($book->codL, $authorSaved->codAu);
            }

            $subjectSaved = $this->subjectRepository->get($bookDTO->getCodSubject());

            $this->bookSubjectRepository->create($book->codL, $subjectSaved->codAs);

            $this->bookRepository->commit();

            return $book;
        } catch (QueryException $e) {
            $this->logger->error(sprintf('[%s] Error in database when creating a new book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'error' => $e->getMessage(),
            ]);

            $this->bookRepository->rollBack();

            throw new RuntimeException('Error when save a new book in database');
        } catch (Throwable $th) {
            $this->logger->error(sprintf('[%s] Unexpected Error when creating a new book', __METHOD__), [
                'book_dto' => $bookDTO->toArray(),
                'error' => $th->getMessage(),
            ]);

            $this->bookRepository->rollBack();

            throw $th;
        }
    }
}
