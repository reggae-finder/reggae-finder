<?php

namespace ReggaeFinder\Utils\DoctrineTestingUtils\PHPUnit;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Types\Type as DoctrineType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

abstract class DoctrineOrmTestCase extends TestCase
{
    private static ?EntityManagerInterface $entityManager = null;
    private ?ORMExecutor $executor = null;

//    public static function setUpBeforeClass(): void
//    {
//        foreach (static::doctrineTypes() as $name => $class) {
//            DoctrineType::addType($name, $class);
//        }
//
//        $config = Setup::createXMLMetadataConfiguration([], isDevMode: true);
//    }
//
//    protected static function doctrineTypes(): array
//    {
//        return [];
//    }


    public static function setEntityManager(EntityManagerInterface $entityManager): void
    {
        self::$entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        if (self::$entityManager === null) {
            throw new \RuntimeException('No entity manager has been set');
        }

        return self::$entityManager;
    }

    protected static function addType(string $name, string $class)
    {
        if (DoctrineType::hasType($name)) {
            DoctrineType::overrideType($name, $class);
            return;
        }

        DoctrineType::addType($name, $class);
    }

    protected function loadFixtures(array $fixtures): void
    {
        $fixturesLoader = new Loader();
        foreach ($fixtures as $fixture) {
            $fixturesLoader->addFixture($fixture);
        }

        $this->getExecutor()->execute($fixturesLoader->getFixtures());
    }

    private function getExecutor(): ORMExecutor
    {
        if ($this->executor === null) {
            $this->executor = new ORMExecutor($this->getEntityManager(), new ORMPurger());
        }

        return $this->executor;
    }
}
