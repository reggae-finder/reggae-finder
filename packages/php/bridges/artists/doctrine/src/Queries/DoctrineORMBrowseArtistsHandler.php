<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Queries;

use Doctrine\ORM\EntityManagerInterface;
use ReggaeFinder\Bridges\Artists\Doctrine\Aggregates\DoctrineArtist;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsCollection;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsHandlerInterface;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsModel;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsQuery;

class DoctrineORMBrowseArtistsHandler implements BrowseArtistsHandlerInterface
{
    private function __construct(private EntityManagerInterface $entityManager) {}

    public static function create(EntityManagerInterface $entityManager)
    {
        return new self($entityManager);
    }

    public function handle(BrowseArtistsQuery $query): BrowseArtistsCollection
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('artist')
            ->from(DoctrineArtist::class, 'artist')
            ->orderBy(sprintf('artist.%s', $query->getSortParam()), $query->getSortOrder())
        ;

        /** @var DoctrineArtist[] $artists */
        $artists = $qb->getQuery()->getResult();

        $models = array_map(function (DoctrineArtist $artist) {
            return BrowseArtistsModel::create($artist->getName());
        }, $artists);

        return BrowseArtistsCollection::create($models);
    }
}
