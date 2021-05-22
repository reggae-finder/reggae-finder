<?php

namespace ReggaeFinder\Domain\Artists\Queries;

final class BrowseArtistsQuery
{
    private function __construct(private BrowseArtistFilter $filter) {}

    public static function create(BrowseArtistFilter $filter): self
    {
        return new self($filter);
    }

    public function getSortParam(): string
    {
        return $this->filter->getSortParam();
    }

    public function getSortOrder(): string
    {
        return $this->filter->getSortOrder();
    }
}
