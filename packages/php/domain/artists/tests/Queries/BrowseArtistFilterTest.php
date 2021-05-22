<?php

namespace ReggaeFinder\Domain\Artists\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistFilter;
use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

class BrowseArtistFilterTest extends TestCase
{
    public function test_it_can_create_a_filter()
    {
        $filter = BrowseArtistFilter::create();

        $this->assertInstanceOf(BrowseArtistFilter::class, $filter);
    }

    public function test_it_can_give_the_default_sort_order()
    {
        $filter = BrowseArtistFilter::create();
        $this->assertEquals(SortOrder::desc(), $filter->getSortOrder());
    }

    public function test_it_can_give_the_default_sort_param()
    {
        $filter = BrowseArtistFilter::create();
        $this->assertEquals(SortParam::create('creationDate'), $filter->getSortParam());
    }
}
