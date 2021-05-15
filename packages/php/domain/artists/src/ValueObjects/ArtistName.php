<?php

namespace ReggaeFinder\Domain\Artists\ValueObjects;

use Assert\Assertion;
use Assert\AssertionFailedException;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNameTooLongException;
use ReggaeFinder\Domain\Artists\Exceptions\ArtistNameTooShortException;

class ArtistName
{
    private const NAME_MIN_LENGTH = 2;
    private const NAME_MAX_LENGTH = 255;

    public function __construct(public string $name)
    {
        try {
            Assertion::minLength($this->name, self::NAME_MIN_LENGTH);
        } catch (AssertionFailedException $e) {
            throw new ArtistNameTooShortException();
        }

        try {
            Assertion::maxLength($this->name, self::NAME_MAX_LENGTH);
        } catch (AssertionFailedException $e) {
            throw new ArtistNameTooLongException();
        }

        $this->name = trim(preg_replace('/\s+/', ' ', $this->name));
    }

    public function equals(self $name): bool
    {
        return (string)$name === $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }


}
