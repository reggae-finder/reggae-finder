<?php

namespace ReggaeFinder\Domain\Artists\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsCollection;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsModel;

class BrowseArtistsCollectionTest extends TestCase
{
    public function test_it_can_create_a_collection()
    {
        $collection = BrowseArtistsCollection::create([
            BrowseArtistsModel::create('Dennis Brown'),
        ]);

        $this->assertInstanceOf(BrowseArtistsCollection::class, $collection);
    }
}
