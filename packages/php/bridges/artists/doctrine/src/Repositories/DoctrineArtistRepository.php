<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Repositories;

use Ramsey\Uuid\UuidInterface;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Services\ArtistRepositoryInterface;

class DoctrineArtistRepository implements ArtistRepositoryInterface
{
    public function add(Artist $artist): void
    {
        // TODO: Implement add() method.
    }

    public function findById(UuidInterface $uuid): Artist
    {

    }

}
