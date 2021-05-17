<?php

namespace ReggaeFinder\Domain\Artists\Tests\ValueObjects;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Utils\Uuid\Exceptions\InvalidUuidException;
use ReggaeFinder\Utils\UuidTesting\UuidTestInterface;

class ArtistIdTest extends TestCase implements UuidTestInterface
{
    public function test_it_can_generate_a_valid_uuid()
    {
        $uuid = ArtistId::generate();

        $this->assertInstanceOf(ArtistId::class, $uuid);
        $this->assertEquals($uuid, ArtistId::fromString((string)$uuid));
    }

    public function test_it_can_be_created_from_a_string()
    {
        $artistId = ArtistId::fromString(UuidTestInterface::UUID_V4);

        $this->assertInstanceOf(ArtistId::class, $artistId);
    }

    public function test_it_cannot_be_created_from_uuid_other_than_v4()
    {
        $this->expectException(InvalidUuidException::class);

        ArtistId::fromString(UuidTestInterface::UUID_V1);
    }

    public function test_it_cannot_be_created_from_non_uuid_string()
    {
        $this->expectException(InvalidUuidException::class);

        ArtistId::fromString(UuidTestInterface::NOT_UUID);
    }

    public function test_it_can_render_as_a_string()
    {
        $artistId = ArtistId::fromString(UuidTestInterface::UUID_V4);

        $this->assertEquals(UuidTestInterface::UUID_V4, (string)$artistId);
    }

    /**
     * @dataProvider stringForUuidValidation
     */
    public function test_it_can_validate_a_string(string $stringToBeValidated, bool $expected)
    {
        $this->assertEquals($expected, ArtistId::validate($stringToBeValidated));
    }

    public function stringForUuidValidation(): array
    {
        return [
            'uuid_v4' => [UuidTestInterface::UUID_V4, true],
            'uuid_v1' => [UuidTestInterface::UUID_V1, false],
            'not_uuid' => [UuidTestInterface::NOT_UUID, false],
        ];
    }
}
