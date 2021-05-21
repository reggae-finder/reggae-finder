<?php

namespace ReggaeFinder\Domain\Artists\Services;

use ReggaeFinder\Domain\Artists\Aggregates\ArtistInterface;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNotFoundException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;

interface ArtistRepositoryInterface
{
    public function add(ArtistInterface $artist): void;

    /**
     * @throws ArtistNotFoundException
     */
    public function findById(ArtistId $artistId): ArtistInterface;
}
