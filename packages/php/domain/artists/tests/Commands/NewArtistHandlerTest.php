<?php

namespace ReggaeFinder\Domain\Artists\Tests\Commands;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Commands\NewArtistCmd;
use ReggaeFinder\Domain\Artists\Commands\NewArtistHandler;
use ReggaeFinder\Domain\Artists\Services\ArtistRepositoryInterface;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class NewArtistHandlerTest extends TestCase
{
    public function test_new_artist_is_added()
    {
        $cmd = new NewArtistCmd('586ae627-0292-4e84-80d8-92deac923204', 'John Holt');

        $repo = $this->getMockBuilder(ArtistRepositoryInterface::class)->getMock();
        $repo->expects($this->once())
            ->method('add')
            ->with(new Artist(new ArtistName('John Holt')))
        ;

        $handler = new NewArtistHandler($repo);
        $handler->handle($cmd);
    }
}
