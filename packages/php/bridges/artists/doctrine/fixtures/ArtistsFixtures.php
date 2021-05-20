<?php

namespace ReggaeFinder\Bridges\Artists\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nyholm\NSA;
use ReggaeFinder\Bridges\Artists\Doctrine\Aggregates\DoctrineArtist;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistId;
use ReggaeFinder\Domain\Artists\ValueObjects\ArtistName;

class ArtistsFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->addJohnHolt($manager);
        $this->addFreddyMcGreggor($manager);

        $manager->flush();
    }

    private function addJohnHolt(ObjectManager $manager): void
    {
        $artist1 = DoctrineArtist::create(
            ArtistId::fromString('586ae627-0292-4e84-80d8-92deac923204'),
            ArtistName::create('John Holt')
        );
        NSA::setProperty($artist1, 'id', 1);
        $manager->persist($artist1);
    }

    private function addFreddyMcGreggor(ObjectManager $manager): void
    {
        $artist2 = DoctrineArtist::create(
            ArtistId::fromString('507398fd-5eeb-4c99-b32e-8a3c203939d7'),
            ArtistName::create('Freddy McGreggor')
        );
        NSA::setProperty($artist2, 'id', 2);
        $manager->persist($artist2);
    }

}
