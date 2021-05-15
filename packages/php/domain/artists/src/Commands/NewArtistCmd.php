<?php

namespace ReggaeFinder\Domain\Artists\Commands;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ReggaeFinder\Domain\Artists\Exceptions\InvalidUuidException;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class NewArtistCmd
{
    public function __construct(
        private string $uuid,
        private string $name,
    ) {
        try {
            $uuidObject = Uuid::fromString($this->uuid);
            $uuidObject->getBytes();

            if ($uuidObject->getVersion() !== 4) {
                throw new InvalidUuidException('uuidV4 expected');
            }
        } catch (InvalidUuidStringException $e) {
            throw new InvalidUuidException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getUuid(): UuidInterface
    {
        return Uuid::fromString($this->uuid);
    }

    public function getName(): ArtistName
    {
        return new ArtistName($this->name);
    }
}
