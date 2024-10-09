<?php

namespace Tests\Unit\Domains\Books\Services;

use App\Domains\Books\DTOs\UpdateBookDTO;
use App\Domains\Books\Repositories\BookAuthorRepositoryInterface;
use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Repositories\BookSubjectRepositoryInterface;
use App\Domains\Books\Services\UpdateBookService;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Database\Factories\SubjectFactory;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Mockery;

class UpdateBookServiceTest extends TestCase
{
    protected LoggerInterface $logger;

    protected BookRepositoryInterface $bookRepository;

    protected BookAuthorRepositoryInterface $bookAuthorRepository;

    protected BookSubjectRepositoryInterface $bookSubjectRepository;

    protected UpdateBookService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = Mockery::mock(LoggerInterface::class);
        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);
        $this->bookAuthorRepository = Mockery::mock(BookAuthorRepositoryInterface::class);
        $this->bookSubjectRepository = Mockery::mock(BookSubjectRepositoryInterface::class);

        $this->service = new UpdateBookService(
            $this->bookRepository,
            $this->bookAuthorRepository,
            $this->bookSubjectRepository,
            $this->logger
        );
    }

    public function testShouldUpdateBookCorrectly(): void {
        $book = BookFactory::new()->make();
        $author = AuthorFactory::new()->make();
        $subject = SubjectFactory::new()->make();

        $bookDTO = new UpdateBookDTO(
            titulo: 'new Title',
            editora: 'new Editor',
            edicao: null,
            anoPublicacao: null,
            valor: 300.50,
            codAutores: [$author->codAu],
            codAssunto: $subject->codAs,
        );

        $updatedBook = BookFactory::new()->make($bookDTO->toArray());
        $updatedBook->codL = $book->codL;
        $updatedBook->edicao = $book->edicao;
        $updatedBook->anoPublicacao = $book->anoPublicacao;

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Updating a book', UpdateBookService::class.'::updateBook'), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => $book->codL,
                ]);

        $this->bookRepository->shouldReceive('beginTransaction')
            ->once();

        $this->bookRepository->shouldReceive('update')
            ->with($bookDTO, $book->codL)
            ->andReturn($updatedBook);

        $this->bookSubjectRepository->shouldReceive('deleteByCodBook')
            ->with($book->codL)
            ->once();

        $this->bookSubjectRepository->shouldReceive('create')
            ->with($book->codL, $subject->codAs)
            ->once();

        $this->bookAuthorRepository->shouldReceive('deleteByCodBook')
            ->with($book->codL)
            ->once();

        $this->bookAuthorRepository->shouldReceive('create')
            ->with($book->codL, $author->codAu)
            ->once();

        $this->bookRepository->shouldReceive('commit')
            ->once();

        $result = $this->service->updateBook($bookDTO, $book->codL);

        $this->assertEquals($updatedBook, $result);
    }

    public function testShouldUpdateBookWithUnexpectedError(): void {
        $bookDTO = new UpdateBookDTO(
            titulo: 'new Title',
            editora: 'new Editor',
            edicao: null,
            anoPublicacao: null,
            valor: 300.50,
            codAutores: [],
            codAssunto: 1,
        );

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Updating a book', UpdateBookService::class.'::updateBook'), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => 1,
                ]);

        $this->bookRepository->shouldReceive('beginTransaction')
            ->once();

        $this->bookRepository->shouldReceive('update')
            ->with($bookDTO, 1)
            ->andReturn(new Exception('Unexpected Error'));

        $this->bookSubjectRepository->shouldReceive('deleteByCodBook')->never();

        $this->bookSubjectRepository->shouldReceive('create')->never();

        $this->bookAuthorRepository->shouldReceive('deleteByCodBook')->never();

        $this->bookAuthorRepository->shouldReceive('create')->never();

        $this->bookRepository->shouldReceive('commit')->never();

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Unexpected Error when update book', UpdateBookService::class.'::updateBook'), [
                'book_dto' => $bookDTO->toArray(),
                'cod_book' => 1,
                'error' => 'Unexpected Error',
            ]);

        $this->bookRepository->shouldReceive('rollback')->once();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unexpected Error');

        $this->service->updateBook($bookDTO, 1);
    }
}
