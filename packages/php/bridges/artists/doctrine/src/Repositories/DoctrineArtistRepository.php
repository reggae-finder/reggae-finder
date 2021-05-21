<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use ReggaeFinder\Bridges\Artists\Doctrine\Aggregates\DoctrineArtist;
use ReggaeFinder\Domain\Artists\Aggregates\ArtistInterface;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNotFoundException;
use ReggaeFinder\Domain\Artists\Services\ArtistRepositoryInterface;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;

final class DoctrineArtistRepository implements ArtistRepositoryInterface
{
    private function __construct(private EntityManagerInterface $entityManager)
    {}

    public static function create(EntityManagerInterface $entityManager): self
    {
        return new self($entityManager);
    }

    public function add(ArtistInterface $artist): void
    {
        $this->entityManager->persist(DoctrineArtist::fromArtist($artist));
        $this->entityManager->flush();
    }

    public function findById(ArtistId $artistId): ArtistInterface
    {
        $artist = $this->getRepo()->findOneBy(['artistId' => $artistId]);

        return $artist ??
            throw new ArtistNotFoundException(sprintf('Cannot find artist #%s', (string)$artistId))
        ;
    }

    private function getRepo(): ObjectRepository
    {
        return $this->entityManager->getRepository(DoctrineArtist::class);
    }

}
