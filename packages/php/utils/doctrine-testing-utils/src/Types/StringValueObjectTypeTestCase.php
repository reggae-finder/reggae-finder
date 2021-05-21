<?php

namespace ReggaeFinder\Utils\DoctrineTestingUtils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReggaeFinder\Utils\DoctrineUtils\Types\StringValueObjectType;

abstract class StringValueObjectTypeTestCase extends TestCase
{
    protected AbstractPlatform|MockObject $platform;

    abstract protected function getType(): StringValueObjectType;
    abstract protected function getValueObject(string $value);

    protected function setUp(): void
    {
        $this->platform = $this->getPlatformMock();
    }

    public function test_it_can_convert_to_database_value()
    {
        $phpValue = $this->getValueObject('value');

        $converted = $this->getType()->convertToDatabaseValue($phpValue, $this->platform);

        $this->assertEquals('value', $converted);
    }

    public function test_it_can_convert_null_php_to_null_db()
    {
        $converted = $this->getType()->convertToDatabaseValue(null, $this->platform);

        $this->assertNull($converted);
    }

    public function test_it_can_convert_to_php_value()
    {
        $dbValue = 'value';
        $expectedVO = $this->getValueObject('value');

        $converted = $this->getType()->convertToPHPValue($dbValue, $this->platform);

        $this->assertEquals($expectedVO, $converted);
    }

    public function test_it_can_convert_null_db_to_null_php()
    {
        $converted = $this->getType()->convertToPHPValue(null, $this->platform);

        $this->assertNull($converted);
    }

    private function getPlatformMock(): AbstractPlatform|MockObject
    {
        $platform = $this->getMockBuilder(AbstractPlatform::class)
            ->disableOriginalConstructor()
//            ->onlyMethods(['getBinaryTypeDeclarationSQL'])
            ->getMockForAbstractClass()
        ;

//        $platform->expects($this->any())
//            ->method('getBinaryTypeDeclarationSQL')->willReturn('DUMMYBINARY(16)')
//        ;

        return $platform;
    }
}
