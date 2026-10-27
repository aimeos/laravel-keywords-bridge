<?php

namespace Aimeos\KeywordsBridge\Drivers;

use Aimeos\KeywordsBridge\Contracts\Driver;
use Aimeos\KeywordsBridge\Keyword;


class Fake implements Driver
{
    public function __construct(public array $config = [])
    {
    }


    public function volume(array $keywords, ?string $country = null): array
    {
        return array_map(fn($keyword) => new Keyword($keyword, 10), $keywords);
    }


    public function related(string $keyword, ?string $country = null, int $limit = 50): array
    {
        return [];
    }
}
