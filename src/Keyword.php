<?php

namespace Aimeos\KeywordsBridge;


final class Keyword implements \JsonSerializable
{
    /**
     * @param string $keyword Keyword text
     * @param int|null $volume Average monthly search volume or NULL if unknown
     */
    public function __construct(
        public readonly string $keyword,
        public readonly ?int $volume = null,
    ) {}


    /**
     * @return array{keyword: string, volume: int|null}
     */
    public function jsonSerialize(): array
    {
        return ['keyword' => $this->keyword, 'volume' => $this->volume];
    }
}
