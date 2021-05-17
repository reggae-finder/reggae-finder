<?php

namespace ReggaeFinder\Utils\UuidTesting;

interface UuidTestInterface
{
    public const UUID_V4 = '586ae627-0292-4e84-80d8-92deac923204';
    public const UUID_V1 = 'de70d0ec-b4e7-11eb-affa-53ef67dc73fe';
    public const NOT_UUID = 'abc123';

    public function test_it_can_generate_a_valid_uuid();

    public function test_it_can_be_created_from_a_string();

    public function test_it_cannot_be_created_from_uuid_other_than_v4();

    public function test_it_cannot_be_created_from_non_uuid_string();

    public function test_it_can_render_as_a_string();

    public function test_it_can_validate_a_string(string $stringToBeValidated, bool $expected);

    /**
     * data provider for the "test_it_can_validate_a_string" method
     */
    public function stringForUuidValidation(): array;
}
