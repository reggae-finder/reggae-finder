<?php

namespace ReggaeFinder\Domain\Artists\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistFilter;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsQuery;

class BrowseArtistsQueryTest extends TestCase
{
    public function test_it_can_create_a_query()
    {
        $query = BrowseArtistsQuery::create(BrowseArtistFilter::create());

        $this->assertInstanceOf(BrowseArtistsQuery::class, $query);
    }

    public function test_it_can_give_the_filter_values_back()
    {
        $filter = BrowseArtistFilter::create();
        $query = BrowseArtistsQuery::create($filter);

        $this->assertSame($filter->getSortParam(), $query->getSortParam());
        $this->assertSame($filter->getSortOrder(), $query->getSortOrder());
    }
}
