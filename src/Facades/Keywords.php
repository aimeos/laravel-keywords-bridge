<?php

namespace Aimeos\KeywordsBridge\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \Aimeos\KeywordsBridge\Contracts\Driver driver(?string $name = null, array<string, mixed> $config = [])
 * @method static array<\Aimeos\KeywordsBridge\Keyword> volume(array<string> $keywords, ?string $country = null)
 * @method static array<\Aimeos\KeywordsBridge\Keyword> related(string $keyword, ?string $country = null, int $limit = 50)
 */
class Keywords extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aimeos\KeywordsBridge\Manager::class;
    }
}
