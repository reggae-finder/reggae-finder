<?php

namespace ReggaeFinder\Domain\Artists\Queries;

class BrowseArtistsModel
{
    private function __construct(private string $name) {}

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
