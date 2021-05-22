<?php

namespace ReggaeFinder\Domain\Artists\Queries;

use ReggaeFinder\Domain\Common\ValueObjects\SortCriteria;
use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

class BrowseArtistFilter
{
    public const SORT_NAME = 'name';
    public const SORT_DATE = 'creationDate';

    private function __construct(private SortCriteria $criteria)
    {}

    public static function create(?SortCriteria $criteria = null): self {
        if ($criteria === null) {
            $criteria = SortCriteria::create(SortParam::create(self::SORT_DATE));
        }

        return new self($criteria);
    }

    public function getSortOrder(): SortOrder
    {
        return $this->criteria->getOrder();
    }

    public function getSortParam(): SortParam
    {
        return $this->criteria->getParam();
    }
}
