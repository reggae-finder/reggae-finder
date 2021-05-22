<?php

namespace ReggaeFinder\Domain\Artists\Tests\Aggregates;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Exceptions\AliasAlreadyInUseException;
use ReggaeFinder\Domain\Artists\Exceptions\AliasIdenticalToNameException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistTest extends TestCase
{
    use PHPMock;

    public function test_can_create_artist()
    {
        $artist = Artist::create(ArtistId::generate(), ArtistName::create('John Holt'));

        $this->assertInstanceOf(Artist::class, $artist);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_it_can_get_the_artist_creation_date()
    {
        $currentTimestamp = 1621673093;

        $time = $this->getFunctionMock('ReggaeFinder\Domain\Artists\Aggregates', 'time');
        $time->expects($this->any())->willReturn($currentTimestamp);

        $artist = Artist::create(ArtistId::generate(), ArtistName::create('John Holt'));

        $this->assertEquals($artist->getCreationDate(), new \DateTimeImmutable('@'.$currentTimestamp));
    }

    public function test_it_can_give_its_name()
    {
        $name = ArtistName::create('John Holt');
        $artist = Artist::create(ArtistId::generate(), $name);

        $this->assertEquals($name, $artist->getName());
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
