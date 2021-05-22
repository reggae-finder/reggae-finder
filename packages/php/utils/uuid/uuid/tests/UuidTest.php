<?php declare(strict_types = 1);

namespace ReggaeFinder\Utils\Uuid\Tests;

use PHPUnit\Framework\TestCase;
use ReggaeFinder\Utils\Uuid\Exceptions\InvalidUuidException;
use ReggaeFinder\Utils\UuidTesting\FakeUuid;
use ReggaeFinder\Utils\UuidTesting\UuidTestInterface;

class UuidTest extends TestCase implements UuidTestInterface
{
    public function test_it_can_generate_a_valid_uuid()
    {
        $uuid = FakeUuid::generate();

        $this->assertInstanceOf(FakeUuid::class, $uuid);
        $this->assertEquals($uuid, FakeUuid::fromString((string)$uuid));
    }

    public function test_it_can_be_created_from_a_string()
    {
        $uuid = FakeUuid::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $this->assertInstanceOf(FakeUuid::class, $uuid);
    }

    public function test_it_can_render_as_a_string()
    {
        $uuid = FakeUuid::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $this->assertEquals('586ae627-0292-4e84-80d8-92deac923204', (string)$uuid);
    }

    public function test_it_cannot_be_created_from_uuid_other_than_v4()
    {
        $this->expectException(InvalidUuidException::class);

        FakeUuid::fromString(UuidTestInterface::UUID_V1);
    }

    public function test_it_cannot_be_created_from_non_uuid_string()
    {
        $this->expectException(InvalidUuidException::class);

        FakeUuid::fromString(UuidTestInterface::NOT_UUID);
    }

    /**
     * @dataProvider stringForUuidValidation
     */
    public function test_it_can_validate_a_string(string $stringToBeValidated, bool $expected)
    {
        $this->assertEquals($expected, FakeUuid::validate($stringToBeValidated));
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
