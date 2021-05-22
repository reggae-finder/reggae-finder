<?php

namespace ReggaeFinder\Domain\Artists\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsCollection;

class BrowsableArtistsCollectionTest extends TestCase
{
    public function it_can_create_a_collection()
    {
        $collection = BrowseArtistsCollection::create();

        $this->assertInstanceOf(BrowseArtistsCollection::class, $collection);
    }
}
