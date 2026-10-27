<?php

namespace Aimeos\KeywordsBridge\Contracts;

use Aimeos\KeywordsBridge\Keyword;


interface Driver
{
    /**
     * Returns the average monthly search volume of the given keywords.
     *
     * @param array<string> $keywords Keywords to get the search volume for
     * @param string|null $country Two letter ISO country code or NULL for worldwide data if supported
     * @return array<Keyword> Keywords with their search volume
     */
    public function volume(array $keywords, ?string $country = null): array;

    /**
     * Returns keywords related to the given one including their search volume.
     *
     * @param string $keyword Seed keyword
     * @param string|null $country Two letter ISO country code or NULL for worldwide data if supported
     * @param int $limit Maximum number of returned keywords
     * @return array<Keyword> Related keywords with their search volume
     */
    public function related(string $keyword, ?string $country = null, int $limit = 50): array;
}
