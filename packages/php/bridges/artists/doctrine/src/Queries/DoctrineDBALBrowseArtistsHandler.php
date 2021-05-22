<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Queries;

use Doctrine\DBAL\Connection;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsCollection;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsHandlerInterface;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsModel;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsQuery;

class DoctrineDBALBrowseArtistsHandler implements BrowseArtistsHandlerInterface
{
    private function __construct(private Connection $connection) {}

    public static function create(Connection $connection): self
    {
        return new self($connection);
    }

    public function handle(BrowseArtistsQuery $query)
    {
        $sql = sprintf('SELECT * FROM artists ORDER BY %s %s',
            strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $query->getSortParam())),
            $query->getSortOrder()
        );

        $stmt = $this->connection->prepare($sql);

        $models = array_map(function ($result) {
            return BrowseArtistsModel::create($result['name']);
        }, $stmt->executeQuery()->fetchAllAssociative());

        return BrowseArtistsCollection::create($models);
    }

}
