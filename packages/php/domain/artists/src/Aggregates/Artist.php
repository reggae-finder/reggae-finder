<?php

namespace ReggaeFinder\Domain\Artists\Aggregates;

use ReggaeFinder\Domain\Artists\Entities\ArtistAlias;
use ReggaeFinder\Domain\Artists\Exceptions\AliasAlreadyInUseException;
use ReggaeFinder\Domain\Artists\Exceptions\AliasIdenticalToNameException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class Artist
{
    /**
     * @var ArtistAlias[]
     */
    private array $aliases = [];

    public function __construct(
        private ArtistId $id,
        private ArtistName $name
    ) {}

    public function addAlias(ArtistName $alias): void
    {
        if ($alias->equals($this->name)) {
            throw new AliasIdenticalToNameException();
        }

        array_walk($this->aliases, function(ArtistAlias $artistAlias) use ($alias) {
            if ($alias->equals($artistAlias->getName())) {
                throw new AliasAlreadyInUseException();
            }
        });

        $this->aliases[] = new ArtistAlias($alias);
    }
}
