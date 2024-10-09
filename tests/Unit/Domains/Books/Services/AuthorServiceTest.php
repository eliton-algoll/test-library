<?php

namespace Tests\Unit\Domains\Books\Services;

use App\Domains\Books\Repositories\AuthorRepositoryInterface;
use App\Domains\Books\Services\AuthorService;
use App\Models\Author;
use Database\Factories\AuthorFactory;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AuthorServiceTest extends TestCase
{
    protected LoggerInterface $logger;

    protected AuthorRepositoryInterface $authorRepository;

    protected AuthorService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = Mockery::mock(LoggerInterface::class);
        $this->authorRepository = Mockery::mock(AuthorRepositoryInterface::class);

        $this->service = new AuthorService($this->authorRepository, $this->logger);
    }

    public function testShouldReturnAAuthorWhenFindByCode(): void
    {
        /** @var Author $author */
        $author = AuthorFactory::new()->make();

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting a author by code', AuthorService::class.'::findByCode'), [
                'cod_author' => $author->codAu,
            ]);

        $this->authorRepository->shouldReceive('get')
            ->with($author->codAu)
            ->once()
            ->andReturn($author);

        $result = $this->service->findByCode($author->codAu);

        $this->assertEquals($author, $result);
    }

    public function testShouldReturnAAuthorWhenUnexpectedError(): void
    {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting a author by code', AuthorService::class.'::findByCode'), [
                'cod_author' => 1,
            ]);

        $this->logger->shouldReceive('error')
            ->with(sprintf('[%s] Unexpected Error when getting a author by code', AuthorService::class.'::findByCode'), [
                'cod_author' => 1,
                'error' => 'Unexpected Error'
            ]);

        $this->authorRepository
            ->shouldReceive('get')
            ->with(1)
            ->andThrow(new Exception('Unexpected Error'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unexpected Error');

        $this->service->findByCode(1);
    }

    public function testShouldBeListAllAuthors(): void
    {
        /** @var Author $author */
        $author = AuthorFactory::new()->make();

        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting all authors', AuthorService::class.'::listAll'));

        $this->authorRepository->shouldReceive('getAll')
            ->withNoArgs()
            ->once()
            ->andReturn(collect([$author]));

        $result = $this->service->listAll();

        $this->assertEquals(collect([$author]), $result);
    }

    public function testShouldBeListAllAuthorsWithEmptyResults(): void
    {
        $this->logger->shouldReceive('info')
            ->with(sprintf('[%s] Try Getting all authors', AuthorService::class.'::listAll'));

        $this->authorRepository->shouldReceive('getAll')
            ->withNoArgs()
            ->once()
            ->andReturn(collect([]));

        $result = $this->service->listAll();

        $this->assertEquals(collect([]), $result);
    }
}
