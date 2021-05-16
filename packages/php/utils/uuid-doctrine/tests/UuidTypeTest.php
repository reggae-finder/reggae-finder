<?php

namespace ReggaeFinder\Utils\UuidDoctrine\Tests;

use Doctrine\DBAL\Types\Type;
use ReggaeFinder\Utils\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTypeTest extends TestCase
{
    private $type;

    public static function setUpBeforeClass(): void
    {
        if (class_exists('Doctrine\\DBAL\\Types\\Type')) {
            Type::addType('uuid', 'ReggaeFinder\Utils\UuidDoctrine');
        }
    }

    protected function setUp(): void
    {
        $this->type = Type::getType('uuid');
    }

    public function test_it_converts_uuid_to_database_value()
    {
        $uuid = Uuid::fromString('ff6f8cb0-c57d-11e1-9b21-0800200c9a66');

        $expected = hex2bin('ff6f8cb0c57d11e19b210800200c9a66');
        $actual = $this->type->convertToDatabaseValue($uuid, $this->platform);

        $this->assertEquals($expected, $actual);
    }
}
