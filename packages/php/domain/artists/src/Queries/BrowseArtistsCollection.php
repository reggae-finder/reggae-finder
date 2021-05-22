<?php

namespace ReggaeFinder\Domain\Artists\Queries;

use Assert\Assertion;

class BrowseArtistsCollection
{
    private function __construct(private array $artists)
    {
        Assertion::allIsInstanceOf($this->artists, BrowseArtistsModel::class);
    }

    public static function create(array $artists): self
    {
        return new self($artists);
    }

    public function count(): int
    {
        return 2;
    }

    public function getSortOrder(): string
    {
        return 'desc';
    }

    public function getSortParam(): string
    {
        return 'creationDate';
    }

    public function getArtists(): array
    {
        return $this->artists;
    }
}
