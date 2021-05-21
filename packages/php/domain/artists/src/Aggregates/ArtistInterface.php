<?php

namespace ReggaeFinder\Domain\Artists\Aggregates;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

interface ArtistInterface
{
    public static function create(ArtistId $id, ArtistName $name): static;

    public function getId(): ArtistId;

    public function addAlias(ArtistName $alias): void;
}
