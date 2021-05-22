<?php

namespace ReggaeFinder\Domain\Artists\Tests\Queries;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Queries\BrowseArtistsModel;

class BrowseArtistsModelTest extends TestCase
{
    public function test_it_can_create_a_model()
    {
        $model = BrowseArtistsModel::create('John Holt');

        $this->assertInstanceOf(BrowseArtistsModel::class, $model);
    }
}
