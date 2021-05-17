<?php

namespace ReggaeFinder\Utils\UuidDoctrine\Tests;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReggaeFinder\Utils\Uuid\Uuid;

class UuidTypeTest extends TestCase
{
    private Type $type;
    private AbstractPlatform|MockObject $platform;

    public static function setUpBeforeClass(): void
    {
        Type::addType('uuid', 'ReggaeFinder\Utils\UuidDoctrine\UuidType');
    }

    protected function setUp(): void
    {
        $this->type = Type::getType('uuid');
        $this->platform = $this->getPlatformMock();
    }

    public function test_it_converts_uuid_to_database_value()
    {
        $uuid = Uuid::fromString('586ae627-0292-4e84-80d8-92deac923204');

        $expected = hex2bin('586ae62702924e8480d892deac923204');
        $actual = $this->type->convertToDatabaseValue($uuid, $this->platform);

        $this->assertEquals($expected, $actual);
    }

    public function test_it_converts_database_value_to_uuid()
    {
        $databaseValue = hex2bin('586ae62702924e8480d892deac923204');
        $actual = $this->type->convertToPHPValue($databaseValue, $this->platform);

        $this->assertEquals(Uuid::fromString('586ae627-0292-4e84-80d8-92deac923204'), $actual);
    }

    public function test_it_generate_the_sql_type_declaration()
    {
        $this->assertEquals('DUMMYBINARY(16)', $this->type->getSqlDeclaration(['length' => 16], $this->platform));
    }

    private function getPlatformMock(): AbstractPlatform|MockObject
    {
        $platform = $this->getMockBuilder(AbstractPlatform::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getBinaryTypeDeclarationSQL'])
            ->getMockForAbstractClass()
        ;

        $platform->expects($this->any())
            ->method('getBinaryTypeDeclarationSQL')->willReturn('DUMMYBINARY(16)')
        ;

        return $platform;
    }
}
