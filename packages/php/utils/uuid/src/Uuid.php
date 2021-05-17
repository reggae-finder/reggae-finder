<?php declare(strict_types = 1);

namespace ReggaeFinder\Utils\Uuid;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\UuidInterface;
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
        try {
            $uuidObject = \Ramsey\Uuid\Uuid::fromString($uuid);
        } catch (InvalidUuidStringException $e) {
            throw new InvalidUuidException($e->getMessage(), $e->getCode(), $e);
        }

        $uuidObject->getBytes();
        $uuidVersion = $uuidObject->getVersion();

        if ($uuidVersion !== \Ramsey\Uuid\Uuid::UUID_TYPE_RANDOM) {
            throw new InvalidUuidException(sprintf('uuidV4 expected, version %s given', $uuidVersion));
        }
        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
