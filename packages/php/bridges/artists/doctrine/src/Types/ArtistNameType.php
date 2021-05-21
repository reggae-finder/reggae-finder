<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Types;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;
use ReggaeFinder\Utils\DoctrineUtils\Types\StringValueObjectType;

class ArtistNameType extends StringValueObjectType
{
    protected function getValueObject(string $string): ArtistName
    {
        return ArtistName::create($string);
    }

    public function getName()
    {
        return 'artist_name';
    }
}
