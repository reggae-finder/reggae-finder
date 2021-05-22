<?php

namespace ReggaeFinder\Utils\UuidDoctrine\Tests;

use ReggaeFinder\Utils\UuidTesting\FakeUuid;
use ReggaeFinder\Utils\Uuid\Uuid;
use ReggaeFinder\Utils\UuidDoctrine\UuidType;

class FakeUuidType extends UuidType
{
    protected function getUuid(string $uuid): Uuid
    {
        return \ReggaeFinder\Utils\UuidTesting\FakeUuid::fromString($uuid);
    }

    public function getName()
    {
        return 'fake';
    }
}
