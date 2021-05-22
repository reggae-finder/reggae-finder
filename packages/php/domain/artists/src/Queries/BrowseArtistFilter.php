<?php

namespace ReggaeFinder\Domain\Artists\Queries;

class BrowseArtistFilter
{
    public const SORT_ASC = 'asc';
    public const SORT_DESC = 'desc';

    public const SORT_NAME = 'name';
    public const SORT_DATE = 'creationDate';

    private function __construct(private string $param, private string $order)
    {}

    public static function create(
        string $param = self::SORT_DATE,
        string $order = self::SORT_DESC,
    ): self {
        return new self($param, $order);
    }

    public function getSortOrder()
    {
        return $this->order;
    }

    public function getSortParam()
    {
        return $this->param;
    }
}
