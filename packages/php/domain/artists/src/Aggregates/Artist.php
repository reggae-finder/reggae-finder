<?php

namespace ReggaeFinder\Domain\Artists\Aggregates;

use ReggaeFinder\Domain\Artists\Entities\ArtistAlias;
use ReggaeFinder\Domain\Artists\Exceptions\AliasAlreadyInUseException;
use ReggaeFinder\Domain\Artists\Exceptions\AliasIdenticalToNameException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class Artist implements ArtistInterface
{
    /**
     * @var ArtistAlias[]
     */
    private array $aliases = [];

    protected \DateTimeImmutable $creationDate;

    protected function __construct(protected ArtistId $artistId, protected ArtistName $name)
    {
        $this->creationDate = new \DateTimeImmutable('@'.time());
    }

    public static function create(ArtistId $artistId, ArtistName $name): static
    {
        return new static($artistId, $name);
    }

    public function getId(): ArtistId
    {
        return $this->artistId;
    }

    public function getName(): ArtistName
    {
        return $this->name;
    }

    public function getCreationDate(): \DateTimeImmutable
    {
        return $this->creationDate;
    }

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
