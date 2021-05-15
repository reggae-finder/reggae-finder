<?php

namespace ReggaeFinder\Domain\Artists\Tests\Entities;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Entities\ArtistAlias;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistAliasTest extends TestCase
{
    public function test_can_create_artist_alias()
    {
        $artist = new ArtistAlias(new ArtistName('Freddie McGreggor'));

        $this->assertIsObject($artist);
    }
}
