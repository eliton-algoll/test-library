<?php

namespace Tests\Unit\Domains\Books\Services;

use App\Domains\Books\Repositories\BookRepositoryInterface;
use App\Domains\Books\Services\DeleteBookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DeleteBookServiceTest extends TestCase
{
    protected LoggerInterface $logger;

    protected BookRepositoryInterface $bookRepository;

    protected DeleteBookService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = Mockery::mock(LoggerInterface::class);
        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);

        $this->service = new DeleteBookService($this->bookRepository, $this->logger);
    }

    public function testShouldDeleteBookCorrectly(): void {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Deleting a book', DeleteBookService::class.'::deleteBook'), [
                'cod_book' => 1,
            ]);

        $this->logger->shouldReceive('error')
            ->never();

        $this->bookRepository->shouldReceive('delete')
            ->with(1)
            ->once();

        $this->service->deleteBook(1);

        $this->assertTrue(true); // Adiciona uma asserção explicita pro phpunit não dar erro, as asserções estão sendo feitas no mock
    }

    public function testShouldDeleteBookWithError(): void {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Deleting a book', DeleteBookService::class.'::deleteBook'), [
                'cod_book' => 1,
            ]);

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Unexpected Error when getting a book by code', DeleteBookService::class.'::deleteBook'), [
                'cod_book' => 1,
                'error' => 'Book not found',
            ]);

        $this->bookRepository->shouldReceive('delete')
            ->with(1)
            ->once()
        ->andThrow(new ModelNotFoundException('Book not found'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Book not found');

        $this->service->deleteBook(1);
    }
}
