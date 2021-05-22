<?php

namespace ReggaeFinder\Utils\DoctrineTestingUtils\PHPUnit;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\BeforeTestHook;

class DoctrineExtension implements BeforeFirstTestHook, BeforeTestHook
{
    private EntityManagerInterface $entityManager;
    private SchemaTool $schemaTool;
    private bool $initialized = false;
    private Configuration $configuration;
    private Connection $connection;

    public function __construct(private string $pathToDb, private array $pathToMappings)
    {
        $this->connection = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'path' => $this->pathToDb],);
        $this->configuration = Setup::createXMLMetadataConfiguration($pathToMappings, isDevMode: true);
        $this->entityManager = EntityManager::create(
//            ['driver' => 'pdo_sqlite', 'path' => $this->pathToDb],
//            Setup::createXMLMetadataConfiguration($pathToMappings, isDevMode: true)
            $this->connection,
            $this->configuration
        );
        $this->schemaTool = new SchemaTool($this->entityManager);

    }

    public function executeBeforeFirstTest(): void
    {

    }


    public function executeBeforeTest(string $test): void
    {
        if (!$this->initialized) {

            $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();

            $this->schemaTool->dropSchema($classes);
            $this->schemaTool->createSchema($classes);
            $this->initialized = true;
        }

        DoctrineOrmTestCase::setEntityManager($this->getNewEntityManager());
    }

    private function getNewEntityManager(): EntityManagerInterface
    {
        return EntityManager::create(
            ['driver' => 'pdo_sqlite', 'path' => $this->pathToDb],
            Setup::createXMLMetadataConfiguration($this->pathToMappings, isDevMode: true)
        );
    }
}
