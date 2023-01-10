<?php

namespace paterni\Behavioral\Command\RealExample;

/**
 * The Concrete Command for scraping the list of movie genres.
 */
class IMDBGenresScrapingCommand extends WebScrapingCommand
{
    public function __construct()
    {
        $this->url = "https://www.imdb.com/feature/genre/";
    }

    /**
     * Extract all genres and their search URLs from the page:
     * https://www.imdb.com/feature/genre/
     */
    public function parse($html): void
    {
        preg_match_all("|href=\"(https://www.imdb.com/search/title\?genres=.*?)\"|", $html, $matches);
        echo "IMDBGenresScrapingCommand: Discovered " . count($matches[1]) . " genres.\n";

        foreach ($matches[1] as $genre) {
            Queue::get()->add(new IMDBGenrePageScrapingCommand($genre));
        }
    }
}
