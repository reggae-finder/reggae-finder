<?php

namespace ReggaeFinder\Utils\UuidDoctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use ReggaeFinder\Utils\Uuid\Uuid;

class UuidType extends Type
{
    /**
     * @var string
     */
    const NAME = 'uuid';

    /**
     * {@inheritdoc}
     *
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBinaryTypeDeclarationSQL(
            [
                'length' => '16',
                'fixed' => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param string|Uuid|null $value
     * @param AbstractPlatform $platform
     *
     * @return Uuid|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            $uuid = \Ramsey\Uuid\Uuid::fromBytes($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return Uuid::fromString((string)$uuid);
    }

    /**
     * {@inheritdoc}
     *
     * @param Uuid|string|null $value
     * @param AbstractPlatform $platform
     *
     * @return string|null
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            $ramseyUuid = \Ramsey\Uuid\Uuid::fromString((string)$value);
            return $ramseyUuid->getBytes();
        }

        try {
            if (is_string($value) || method_exists($value, '__toString')) {
                return \Ramsey\Uuid\Uuid::fromString((string) $value)->getBytes();
            }
        } catch (\InvalidArgumentException $e) {
            // Ignore the exception and pass through.
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritdoc}
     *
     * @param AbstractPlatform $platform
     *
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
