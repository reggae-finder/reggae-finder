<?php declare(strict_types = 1);

namespace ReggaeFinder\Utils\Uuid\Tests;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Utils\Uuid\Exceptions\InvalidUuidException;
use ReggaeFinder\Utils\Uuid\Uuid;

class UuidTest extends TestCase
{
    public function test_it_can_generate_a_valid_uuid()
    {
        $uuid = Uuid::generate();

        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertEquals($uuid, Uuid::fromString((string)$uuid));
    }

    public function test_it_can_be_created_from_a_string()
    {
        $uuid = Uuid::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function test_cannot_pass_uuid_other_than_v4()
    {
        $this->expectException(InvalidUuidException::class);

        Uuid::fromString('de70d0ec-b4e7-11eb-affa-53ef67dc73fe');
    }

    public function test_cannot_pass_invalid_uuid()
    {
        $this->expectException(InvalidUuidException::class);

        Uuid::fromString('abc123');
    }

    public function test_it_can_render_as_a_string()
    {
        $uuid = Uuid::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $this->assertEquals('586ae627-0292-4e84-80d8-92deac923204', (string)$uuid);
    }

    public function test_it_can_validate_a_V4_string()
    {
        $result = Uuid::validate('586ae627-0292-4e84-80d8-92deac923204');
    }
}
