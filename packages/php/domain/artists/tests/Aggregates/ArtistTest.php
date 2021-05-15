<?php

namespace ReggaeFinder\Domain\Artists\Tests\Aggregates;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Entities\ArtistAlias;
use ReggaeFinder\Domain\Artists\Exceptions\AliasAlreadyInUseException;
use ReggaeFinder\Domain\Artists\Exceptions\AliasIdenticalToNameException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistTest extends TestCase
{
    public function test_can_create_artist()
    {
        $artist = new Artist(new ArtistName('John Holt'));

        $this->assertIsObject($artist);
    }

    public function test_can_add_alias_to_artist()
    {
        $artist = new Artist(new ArtistName('Freddy McGreggor'));
        $artist->addAlias(new ArtistName('Freddie McGreggor'));
    }

    public function test_cannot_add_alias_same_as_name()
    {
        $this->expectException(AliasIdenticalToNameException::class);

        $artist = new Artist(new ArtistName('Freddy McGreggor'));
        $artist->addAlias(new ArtistName('Freddy McGreggor'));
    }

    public function test_cannot_add_same_alias_multiple_times()
    {
        $this->expectException(AliasAlreadyInUseException::class);

        $artist = new Artist(new ArtistName('Freddy McGreggor'));
        $artist->addAlias(new ArtistName('Freddie McGreggor'));
        $artist->addAlias(new ArtistName('Freddie McGreggor'));
    }
}
