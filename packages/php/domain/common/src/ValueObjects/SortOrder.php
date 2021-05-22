<?php

namespace ReggaeFinder\Domain\Common\ValueObjects;

class SortOrder
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    private function __construct(private string $order) {}

    public static function asc(): self
    {
        return new self(self::ASC);
    }

    public static function desc(): self
    {
        return new self(self::DESC);
    }

    public function getOrder(): string
    {
        return $this->order;
    }
}
