<?php

namespace ReggaeFinder\Domain\Artists\Queries;

interface BrowseArtistsHandlerInterface
{
    public function handle(BrowseArtistsQuery $query);
}
