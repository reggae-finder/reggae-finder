<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Tests\Repositories;

use ReggaeFinder\Bridges\Artists\Doctrine\Aggregates\DoctrineArtist;
use ReggaeFinder\Bridges\Artists\Doctrine\Fixtures\ArtistsFixtures;
use ReggaeFinder\Bridges\Artists\Doctrine\Repositories\DoctrineArtistRepository;
use ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistIdType;
use ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistNameType;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNotFoundException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;
use ReggaeFinder\Utils\DoctrineTestingUtils\PHPUnit\DoctrineOrmTestCase;

class DoctrineArtistRepositoryTest extends DoctrineOrmTestCase
{
    private DoctrineArtistRepository $repository;

    public static function setUpBeforeClass(): void
    {
        self::addType('artist_id', ArtistIdType::class);
        self::addType('artist_name', ArtistNameType::class);
    }

    protected function setUp(): void
    {
        $this->loadFixtures([new ArtistsFixtures()]);
        $this->repository = DoctrineArtistRepository::create($this->getEntityManager());
    }

    public function test_it_can_creates_the_repository()
    {
        $repository = DoctrineArtistRepository::create($this->getEntityManager());

        $this->assertInstanceOf(DoctrineArtistRepository::class, $repository);
    }

    public function test_it_can_find_an_artist_with_its_id()
    {
        $uuid = ArtistId::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $artist = $this->repository->findById($uuid);

        $this->assertInstanceOf(DoctrineArtist::class, $artist);
        $this->assertEquals($uuid, $artist->getId());
    }

    public function test_it_can_add_and_retrieve_an_artist()
    {
        $artistId = ArtistId::fromString('063d84ad-2d10-4730-bd9f-6ea42f30cd72');
        $artist = Artist::create($artistId, ArtistName::create('Jah Shaka'));

        $this->repository->add($artist);

        $artistFromRepo = $this->repository->findById($artistId);
        $this->assertEquals($artist->getId(), $artistFromRepo->getId());
    }

    public function test_it_cannot_find_undefined_artist()
    {
        $artistId = ArtistId::generate();

        $this->expectException(ArtistNotFoundException::class);
        $this->repository->findById($artistId);
    }
}
