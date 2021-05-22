<?php

namespace ReggaeFinder\Domain\Common\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;

class SortOrderTest extends TestCase
{
    public function test_it_can_create_an_asc_order()
    {
        $order = SortOrder::asc();

        $this->assertInstanceOf(SortOrder::class, $order);
        $this->assertEquals('asc', $order->getOrder());
    }

    public function test_it_can_create_a_desc_order()
    {
        $order = SortOrder::desc();

        $this->assertInstanceOf(SortOrder::class, $order);
        $this->assertEquals('desc', $order->getOrder());
    }
}
