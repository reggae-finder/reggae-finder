<?php

namespace ReggaeFinder\Domain\Artists\Entities;

use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistAlias
{
    public function __construct(public ArtistName $name)
    {}

    public function getName(): ArtistName
    {
        return $this->name;
    }
}
