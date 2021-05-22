<?php

namespace ReggaeFinder\Domain\Common\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Common\ValueObjects\SortCriteria;
use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

class SortCriteriaTest extends TestCase
{
    public function test_it_can_create_a_sort_criteria()
    {
        $criteria = SortCriteria::create(SortParam::create('name'));

        $this->assertInstanceOf(SortCriteria::class, $criteria);
    }

    public function test_it_can_give_the_param_back()
    {
        $criteria = SortCriteria::create(SortParam::create('name'));

        $this->assertEquals('name', $criteria->getParam());
    }

    public function test_it_sets_the_default_order_to_desc()
    {
        $criteria = SortCriteria::create(SortParam::create('name'));

        $this->assertEquals(SortOrder::desc(), $criteria->getOrder());
    }

    public function test_it_can_use_asc_order()
    {
        $criteria = SortCriteria::create('name', 'asc');

        $this->assertEquals('asc', $criteria->getOrder());
    }
}
