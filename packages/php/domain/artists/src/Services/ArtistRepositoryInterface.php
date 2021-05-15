<?php

namespace ReggaeFinder\Domain\Artists\Services;

use Ramsey\Uuid\UuidInterface;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;

interface ArtistRepositoryInterface
{
    public function add(Artist $artist): void;
    public function findById(UuidInterface $uuid): Artist;
}
