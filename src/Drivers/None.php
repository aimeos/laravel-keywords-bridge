<?php

namespace Aimeos\KeywordsBridge\Drivers;

use Aimeos\KeywordsBridge\Contracts\Driver;


class None implements Driver
{
    public function volume(array $keywords, ?string $country = null): array
    {
        return [];
    }


    public function related(string $keyword, ?string $country = null, int $limit = 50): array
    {
        return [];
    }
}
