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

            foreach($bookDTO->getAuthors() as $author) {
                $authorDTO = new AuthorDTO(nome: $author);

                $authorSaved = $this->authorRepository->create($authorDTO);

                $this->bookAuthorRepository->create($book->codL, $authorSaved->codAu);
            }

            foreach($bookDTO->getSubjects() as $subject) {
                $subjectDTO = new SubjectDTO(descricao: $subject);

                $subjectSaved = $this->subjectRepository->create($subjectDTO);

                $this->bookSubjectRepository->create($book->codL, $subjectSaved->codAs);
            }

            $this->bookRepository->commit();

            return $book;
        } catch (QueryException $e) {
            dd($e->getMessage());
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
