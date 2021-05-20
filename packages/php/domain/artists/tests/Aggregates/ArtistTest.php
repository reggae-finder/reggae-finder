<?php

namespace ReggaeFinder\Domain\Artists\Tests\Aggregates;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Exceptions\AliasAlreadyInUseException;
use ReggaeFinder\Domain\Artists\Exceptions\AliasIdenticalToNameException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistTest extends TestCase
{
    public function test_can_create_artist()
    {
        $artist = Artist::create(ArtistId::generate(), ArtistName::create('John Holt'));

        $this->assertInstanceOf(Artist::class, $artist);
    }

    public function test_cannot_add_alias_same_as_name()
    {
        $this->expectException(AliasIdenticalToNameException::class);

        $artist = Artist::create(ArtistId::generate(), ArtistName::create('Freddy McGreggor'));
        $artist->addAlias(ArtistName::create('Freddy McGreggor'));
    }

    public function test_cannot_add_same_alias_multiple_times()
    {
        $this->expectException(AliasAlreadyInUseException::class);

        $artist = Artist::create(ArtistId::generate(), ArtistName::create('Freddy McGreggor'));
        $artist->addAlias(ArtistName::create('Freddie McGreggor'));
        $artist->addAlias(ArtistName::create('Freddie McGreggor'));
    }
}
