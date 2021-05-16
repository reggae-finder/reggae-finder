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


return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

