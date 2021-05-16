<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Tests\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use ReggaeFinder\Bridges\Artists\Doctrine\Repositories\DoctrineArtistRepository;

class DoctrineArtistRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $dbParams = [
            'driver' => 'pdo_sqlite',
            'path' => '../ttest_db.sqlit',
        ];

        $isDevMode = true;

        $paths = ['../../config/mappings'];

        $config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);

        $entityManager->getConnection()->ping();
    }

    public function test_can_find_an_artist_with_its_id()
    {
        $repository = new DoctrineArtistRepository();
        $uuid = Uuid::fromString('586ae627-0292-4e84-80d8-92deac923204');
        $artist = $repository->findById($uuid);
    }
}
