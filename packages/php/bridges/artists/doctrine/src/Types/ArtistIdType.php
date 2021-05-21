<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Types;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Utils\UuidDoctrine\UuidType;

class ArtistIdType extends UuidType
{
    protected function getUuid(string $uuid): ArtistId
    {
        return ArtistId::fromString($uuid);
    }

    public function getName()
    {
        return 'artist_id';
    }
}
