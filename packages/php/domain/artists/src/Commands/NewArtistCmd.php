<?php

namespace ReggaeFinder\Domain\Artists\Commands;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class NewArtistCmd
{
    private ArtistId $artistId;
    private ArtistName $artistName;

    public function __construct(string $artistId, string $name)
    {
        $this->artistId = ArtistId::fromString($artistId);
        $this->artistName = ArtistName::create($name);
    }

    public function getArtistId(): ArtistId
    {
        return $this->artistId;
    }

    public function getName(): ArtistName
    {
        return $this->artistName;
    }
}
