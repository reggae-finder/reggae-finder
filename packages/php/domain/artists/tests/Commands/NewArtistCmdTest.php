<?php

namespace ReggaeFinder\Domain\Artists\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use ReggaeFinder\Domain\Artists\Commands\NewArtistCmd;
use ReggaeFinder\Domain\Artists\Exceptions\InvalidUuidException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class NewArtistCmdTest extends TestCase
{
    public function test_cannot_pass_invalid_uuid()
    {
        $this->expectException(InvalidUuidException::class);

        $cmd = new NewArtistCmd('abc123', 'John Holt');
    }

    public function test_cannot_pass_uuid_other_than_v4()
    {
        $this->expectException(InvalidUuidException::class);

        $cmd = new NewArtistCmd('de70d0ec-b4e7-11eb-affa-53ef67dc73fe', 'John Holt');
    }

    public function test_it_returns_uuid_object()
    {
        $cmd = new NewArtistCmd('586ae627-0292-4e84-80d8-92deac923204', 'John Holt');
        $uuid = $cmd->getUuid();

        $this->assertInstanceOf(UuidInterface::class, $uuid);
    }

    public function test_it_returns_artist_name_object()
    {
        $cmd = new NewArtistCmd('5cb6ded0-a687-4849-aa47-d61e55a8c51f', 'John Holt');
        $name = $cmd->getName();

        $this->assertInstanceOf(ArtistName::class, $name);
        $this->assertTrue($name->equals(new ArtistName('John Holt')));
    }
}
