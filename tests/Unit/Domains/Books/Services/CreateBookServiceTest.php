<?php

namespace Tests\Unit\Domains\Books\Services;

use App\Domains\Books\DTOs\BookDTO;
use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Domains\Books\Repositories\SubjectRepositoryInterface;
use App\Domains\Books\Services\CreateBookService;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Database\Factories\SubjectFactory;
use Illuminate\Database\QueryException;
use Mockery;
use PDOException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CreateBookServiceTest extends TestCase
{
    protected LoggerInterface $logger;

    protected BookRepositoryInterface $bookRepository;

    protected AuthorRepositoryInterface $authorRepository;

    private BookAuthorRepositoryInterface $bookAuthorRepository;

    private SubjectRepositoryInterface $subjectRepository;

    private BookSubjectRepositoryInterface $bookSubjectRepository;

    protected CreateBookService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = Mockery::mock(LoggerInterface::class);
        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);
        $this->authorRepository = Mockery::mock(AuthorRepositoryInterface::class);
        $this->bookAuthorRepository = Mockery::mock(BookAuthorRepositoryInterface::class);
        $this->subjectRepository = Mockery::mock(SubjectRepositoryInterface::class);
        $this->bookSubjectRepository = Mockery::mock(BookSubjectRepositoryInterface::class);

        $this->service = new CreateBookService(
            $this->bookRepository,
            $this->authorRepository,
            $this->bookAuthorRepository,
            $this->subjectRepository,
            $this->bookSubjectRepository,
            $this->logger
        );
    }

    public function testShouldBeCreateABookCorrectly(): void
    {
        $book = BookFactory::new()->make();
        $author = AuthorFactory::new()->make();
        $subject = SubjectFactory::new()->make();

        $bookDTO = new BookDTO(
            titulo: $book->titulo,
            editora: $book->editora,
            edicao: $book->edicao,
            anoPublicacao: $book->anoPublicacao,
            valor: $book->valor,
            codAutores: [$author->codAu],
            codAssunto: $subject->codAs,
        );

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Creating a new book', CreateBookService::class.'::firstOrCreateByDTO'), [
                'book_dto' => $bookDTO->toArray(),
            ]);

        $this->bookRepository->shouldReceive('beginTransaction')
            ->once();

        $this->bookRepository->shouldReceive('create')
            ->with($bookDTO)
            ->once()
            ->andReturn($book);

        $this->authorRepository->shouldReceive('get')
            ->with($author->codAu)
            ->once()
            ->andReturn($author);

        $this->bookAuthorRepository->shouldReceive('create')
            ->with($book->codL, $author->codAu)
            ->once();

        $this->subjectRepository->shouldReceive('get')
            ->with($subject->codAs)
            ->once()
            ->andReturn($subject);

        $this->bookSubjectRepository->shouldReceive('create')
            ->with($book->codL, $subject->codAs)
            ->once();

        $this->bookRepository->shouldReceive('commit')
            ->once();

        $result = $this->service->firstOrCreateByDTO($bookDTO);

        $this->assertEquals($book, $result);
    }

    public function testShouldBeCreateABookWithError(): void
    {
        $bookDTO = new BookDTO(
            titulo: 'fake',
            editora: 'abril',
            edicao: 1,
            anoPublicacao: 1,
            valor: 1,
            codAutores: [],
            codAssunto: 1,
        );

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Creating a new book', CreateBookService::class.'::firstOrCreateByDTO'), [
                'book_dto' => $bookDTO->toArray(),
            ]);

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Error in database when creating a new book', CreateBookService::class.'::firstOrCreateByDTO'), [
                'book_dto' => $bookDTO->toArray(),
                'error' => 'Error in database (Connection: mysql, SQL: )',
            ]);

        $this->bookRepository->shouldReceive('beginTransaction')
            ->once();

        $this->bookRepository->shouldReceive('create')
            ->with($bookDTO)
            ->once()
            ->andThrow(new QueryException('mysql', '', [], new PDOException('Error in database')));

        $this->bookRepository->shouldReceive('rollback')
            ->once();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Error when save a new book in database');

        $this->service->firstOrCreateByDTO($bookDTO);
    }
}
