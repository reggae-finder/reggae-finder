<?php

namespace ReggaeFinder\Domain\Artists\Tests\ValueObjects;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNameTooLongException;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNameTooShortException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistNameTest extends TestCase
{
    public function test_can_create_artist_name()
    {
        $name = 'John Holt';
        $artistName = ArtistName::create($name);

        $this->assertIsObject($artistName);
    }

    public function test_cannot_create_artist_with_long_name()
    {
        $this->expectException(ArtistNameTooLongException::class);

        ArtistName::create(str_pad('john', 300, 'holt'));
    }

    public function test_cannot_create_artist_with_short_name()
    {
        $this->expectException(ArtistNameTooShortException::class);

        ArtistName::create('j');
    }

    public function test_extra_whitespace_are_removed()
    {
        $nameWithSpaces = ArtistName::create('   John    Holt   ');
        $nameWithoutSpaces = ArtistName::create('John Holt');

        $this->assertTrue($nameWithoutSpaces->equals($nameWithSpaces));
    }
}
