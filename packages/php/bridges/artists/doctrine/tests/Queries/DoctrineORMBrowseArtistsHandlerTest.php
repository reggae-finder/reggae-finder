<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Tests\Queries;

use ReggaeFinder\Bridges\Artists\Doctrine\Fixtures\BrowseArtistsHandlerFixtures;
use ReggaeFinder\Bridges\Artists\Doctrine\Queries\DoctrineORMBrowseArtistsHandler;
use ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistIdType;
use ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistNameType;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsHandlerInterface;
use ReggaeFinder\Utils\DoctrineTestingUtils\PHPUnit\DoctrineOrmTestCase;
use ReggaeFinder\Utils\DomainTesting\ArtistsTestingUtils\BrowseArtistsHandlerTestTrait;

class DoctrineORMBrowseArtistsHandlerTest extends DoctrineOrmTestCase
{
    use BrowseArtistsHandlerTestTrait;

    public static function setUpBeforeClass(): void
    {
        self::addType('artist_id', ArtistIdType::class);
        self::addType('artist_name', ArtistNameType::class);
    }

    protected function setUp(): void
    {
        $this->loadFixtures([new BrowseArtistsHandlerFixtures()]);
    }

    protected function getHandler(): BrowseArtistsHandlerInterface
    {
        return DoctrineORMBrowseArtistsHandler::create($this->getEntityManager());
    }

    public function test_it_can_create_the_handler()
    {
        $handler = $this->getHandler();

        $this->assertInstanceOf(DoctrineORMBrowseArtistsHandler::class, $handler);
    }
}
