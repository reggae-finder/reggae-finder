<?php

namespace ReggaeFinder\Utils\DomainTesting\ArtistsTestingUtils;

use ReggaeFinder\Domain\Artists\Queries\BrowseArtistFilter;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsCollection;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsHandlerInterface;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsModel;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsQuery;
use ReggaeFinder\Domain\Common\ValueObjects\SortCriteria;
use ReggaeFinder\Domain\Common\ValueObjects\SortOrder;
use ReggaeFinder\Domain\Common\ValueObjects\SortParam;

trait BrowseArtistsHandlerTestTrait
{
    abstract protected function getHandler(): BrowseArtistsHandlerInterface;

    public function test_it_can_return_a_browsable_artists_collection()
    {
        $handler = $this->getHandler();

        $filter = BrowseArtistFilter::create();
        $collection = $handler->handle(BrowseArtistsQuery::create($filter));

        $this->assertInstanceOf(BrowseArtistsCollection::class, $collection);
        $this->assertEquals(2, $collection->count());
        $this->assertEquals($filter->getSortOrder(), $collection->getSortOrder());
        $this->assertEquals($filter->getSortParam(), $collection->getSortParam());
        $this->assertContainsOnlyInstancesOf(BrowseArtistsModel::class, $collection->getArtists());
    }

    public function test_it_can_sort_alphabetically()
    {
        $handler = $this->getHandler();

        $filter = BrowseArtistFilter::create(SortCriteria::create(
            SortParam::create(BrowseArtistFilter::SORT_NAME),
            SortOrder::asc()
        ));
        $collection = $handler->handle(BrowseArtistsQuery::create($filter));

        /** @var BrowseArtistsModel $artist */
        foreach ($collection->getArtists() as $artist) {
            if (!isset($refName)) {
                $refName = $artist->getName();
                continue;
            }

            $this->assertGreaterThan($refName, $artist->getName());
            $refName = $artist->getName();
        }
    }

    public function test_it_can_sort_reverse_alphabetically()
    {
        $handler = $this->getHandler();

        $filter = BrowseArtistFilter::create(SortCriteria::create(
            SortParam::create(BrowseArtistFilter::SORT_NAME),
            SortOrder::desc()
        ));
        $collection = $handler->handle(BrowseArtistsQuery::create($filter));

        /** @var BrowseArtistsModel $artist */
        foreach ($collection->getArtists() as $artist) {
            if (!isset($refName)) {
                $refName = $artist->getName();
                continue;
            }

            $this->assertLessThan($refName, $artist->getName());
            $refName = $artist->getName();
        }
    }
}
