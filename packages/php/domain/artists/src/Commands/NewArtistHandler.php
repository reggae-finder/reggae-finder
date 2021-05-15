<?php

namespace ReggaeFinder\Domain\Artists\Commands;

use ReggaeFinder\Domain\Artists\Aggregates\Artist;
use ReggaeFinder\Domain\Artists\Services\ArtistRepositoryInterface;

class NewArtistHandler
{
    public function __construct(private ArtistRepositoryInterface $artistRepository)
    {}

    public function handle(NewArtistCmd $cmd): void
    {
        $artist = new Artist($cmd->getName());

        $this->artistRepository->add($artist);
    }
}
