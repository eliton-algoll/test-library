<?php

namespace Tests\Unit\Domains\Books\Services;

use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Services\BookService;
use App\Models\Book;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Exception;

class BookServiceTest extends TestCase
{
    protected LoggerInterface $logger;

    protected BookRepositoryInterface $bookRepository;

    protected BookService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = Mockery::mock(LoggerInterface::class);
        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);

        $this->service = new BookService($this->bookRepository, $this->logger);
    }

    public function testShouldReturnABookWhenFindByCode(): void
    {
        /** @var Book $book */
        $book = BookFactory::new()->make();

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting a book by code', BookService::class.'::findByCode'), [
                'cod_book' => $book->codL,
            ]);

        $this->bookRepository->shouldReceive('get')
            ->with($book->codL)
            ->once()
            ->andReturn($book);

        $result = $this->service->findByCode($book->codL);

        $this->assertEquals($book, $result);
    }

    public function testShouldReturnABookWhenModelNotFound(): void
    {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting a book by code', BookService::class.'::findByCode'), [
                'cod_book' => 1,
            ]);

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Error when getting a book by code', BookService::class.'::findByCode'), [
                'cod_book' => 1,
                'error' => 'Book not found'
            ]);

        $this->bookRepository
            ->shouldReceive('get')
            ->with(1)
            ->andThrow(new ModelNotFoundException('Book not found'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Book not found');

        $this->service->findByCode(1);
    }

    public function testShouldReturnABookWhenUnexpectedError(): void
    {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting a book by code', BookService::class.'::findByCode'), [
                'cod_book' => 1,
            ]);

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Unexpected Error when getting a book by code', BookService::class.'::findByCode'), [
                'cod_book' => 1,
                'error' => 'Book not found'
            ]);

        $this->bookRepository
            ->shouldReceive('get')
            ->with(1)
            ->andThrow(new Exception('Unexpected Error'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unexpected Error');

        $this->service->findByCode(1);
    }

    public function testShouldBeListAllBooksWithEmptyResults(): void
    {
        $filters = [];
        $order = [];
        $itemsPerPage = 10;

        $paginatorMock = Mockery::mock(Paginator::class);

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting all books', BookService::class.'::listAll'));

        $this->bookRepository->shouldReceive('getAll')
            ->with($filters, $order, $itemsPerPage)
            ->once()
            ->andReturn($paginatorMock);

        $result = $this->service->listAll($filters, $order, $itemsPerPage);

        $this->assertInstanceOf(Paginator::class, $result);
    }

    public function testShouldBeListAllBooksWhenReceiveUnexpectedError(): void
    {
        $filters = ['titulo' => 'fake'];
        $order = [];
        $itemsPerPage = 10;

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting all books', BookService::class.'::listAll'));

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Unexpected Error when getting all books', BookService::class.'::findByCode'), [
                'filters' => $filters,
                'error' => 'Book not found'
            ]);

        $this->bookRepository->shouldReceive('getAll')
            ->with($filters, $order, $itemsPerPage)
            ->once()
            ->andThrow(new Exception('Unexpected Error'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unexpected Error');

        $this->service->listAll($filters, $order, $itemsPerPage);
    }
}
