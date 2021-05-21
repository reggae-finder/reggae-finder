<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once "vendor/autoload.php";

$dbParams = [
    'driver' => 'pdo_sqlite',
    'path' => '../test.db',
];

$isDevMode = true;

$paths = [__DIR__ .'/config/mappings'];

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

\Doctrine\DBAL\Types\Type::addType('artist_id', \ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistIdType::class);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
