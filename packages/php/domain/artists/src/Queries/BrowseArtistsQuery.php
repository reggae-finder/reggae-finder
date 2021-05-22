<?php

namespace ReggaeFinder\Domain\Artists\Queries;

use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

final class BrowseArtistsQuery
{
    private function __construct(private BrowseArtistFilter $filter) {}

    public static function create(BrowseArtistFilter $filter): self
    {
        return new self($filter);
    }

    public function getSortParam(): SortParam
    {
        return $this->filter->getSortParam();
    }

    public function getSortOrder(): SortOrder
    {
        return $this->filter->getSortOrder();
    }
}
