<?php

namespace ReggaeFinder\Utils\DoctrineTestingUtils\PHPUnit;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Runner\BeforeTestHook;

class DoctrineExtension implements BeforeTestHook
{
    private EntityManagerInterface $entityManager;
    private SchemaTool $schemaTool;
    private bool $initialized = false;

    public function __construct(private string $pathToDb, array $pathToMappings)
    {
        $this->entityManager = EntityManager::create(
            ['driver' => 'pdo_sqlite', 'path' => $this->pathToDb],
            Setup::createXMLMetadataConfiguration($pathToMappings, isDevMode: true)
        );
        $this->schemaTool = new SchemaTool($this->entityManager);

        DoctrineOrmTestCase::setEntityManager($this->entityManager);
    }

    public function executeBeforeTest(string $test): void
    {
        var_dump('executeBeforeTest');

        if (!$this->initialized) {
            $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();

            $this->schemaTool->dropSchema($classes);
            $this->schemaTool->createSchema($classes);
            $this->initialized = true;
        }
    }
}
