<?php

namespace ReggaeFinder\Utils\DoctrineUtils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

abstract class StringValueObjectType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return $this->getValueObject((string)$value);
    }

    abstract protected function getValueObject(string $string);
}
