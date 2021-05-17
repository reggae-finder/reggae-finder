<?php declare(strict_types = 1);

namespace ReggaeFinder\Utils\Uuid;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use ReggaeFinder\Utils\Uuid\Exceptions\InvalidUuidException;

class Uuid
{
    private function __construct(private string $uuid)
    {}

    public static function generate(): static
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public static function fromString(string $uuid): static
    {
        if (!self::validate($uuid)) {
            throw new InvalidUuidException(sprintf('Invalid UUID V4 given: %s', $uuid));
        }

        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function validate(string $uuid): bool
    {
        try {
            $uuidObject = \Ramsey\Uuid\Uuid::fromString($uuid);
        } catch (InvalidUuidStringException $e) {
            return false;
        }

        $uuidVersion = $uuidObject->getVersion();

        return $uuidVersion === \Ramsey\Uuid\Uuid::UUID_TYPE_RANDOM;
    }
}
