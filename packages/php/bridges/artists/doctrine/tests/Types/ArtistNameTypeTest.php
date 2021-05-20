<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Tests\Types;

use ReggaeFinder\Bridges\Artists\Doctrine\Types\ArtistNameType;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;
use ReggaeFinder\Utils\DoctrineTestingUtils\Types\StringValueObjectTypeTestCase;
use ReggaeFinder\Utils\DoctrineUtils\Types\StringValueObjectType;

class ArtistNameTypeTest extends StringValueObjectTypeTestCase
{
    protected function getType(): StringValueObjectType
    {
        return new ArtistNameType();
    }

    protected function getValueObject(string $value): ArtistName
    {
        return ArtistName::create($value);
    }

    public function test_it_can_give_its_name()
    {
        $type = $this->getType();

        $this->assertEquals('artist_name', $type->getName());
    }
}
