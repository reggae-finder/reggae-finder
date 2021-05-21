<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Aggregates;

use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Aggregates\ArtistInterface;

final class DoctrineArtist extends Artist implements ArtistInterface
{
    private ?int $id = null;

    public static function fromArtist(Artist $artist): self
    {
        return new self($artist->artistId, $artist->name);
    }
}
