<?php

namespace ReggaeFinder\Domain\Common\ValueObjects;

class SortCriteria
{
    private function __construct(private SortParam $param, private SortOrder $order) {}

    public static function create(SortParam $param, ?SortOrder $order = null): self
    {
        if ($order === null) {
            $order = SortOrder::desc();
        }

        return new self($param, $order);
    }

    public function getParam(): SortParam
    {
        return $this->param;
    }

    public function getOrder(): SortOrder
    {
        return $this->order;
    }
}
