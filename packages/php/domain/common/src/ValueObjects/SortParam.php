<?php

namespace ReggaeFinder\Domain\Common\ValueObjects;

class SortParam
{
    private function __construct(private string $param) {}

    public static function create(string $param): self
    {
        return new self($param);
    }

    public function getParam(): string
    {
        return $this->param;
    }
}
