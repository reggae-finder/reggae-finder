<?php

namespace ReggaeFinder\Domain\Artists\Commands;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;
use ReggaeFinder\Utils\Uuid\Uuid;

class NewArtistCmd
{
    public function __construct(
        private string $uuid,
        private string $name,
    ) {
        Uuid::fromString($this->uuid);
    }

    public function getUuid(): Uuid
    {
        return Uuid::fromString($this->uuid);
    }

    public function getName(): ArtistName
    {
        return new ArtistName($this->name);
    }
}
