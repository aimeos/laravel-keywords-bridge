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
     * Normalizes the keyword like the keyword services do.
     *
     * @param string $keyword Keyword
     * @return string Trimmed keyword in lower case with single spaces
     */
    public static function normalize(string $keyword): string
    {
        return mb_strtolower(trim((string) preg_replace('/\s+/u', ' ', $keyword)));
    }


    /**
     * Normalizes the keywords and removes empty and duplicate ones.
     *
     * @param array<int, string> $keywords List of keywords
     * @return array<int, string> List of unique, normalized keywords
     */
    public static function unique(array $keywords): array
    {
        $keywords = array_map(fn($keyword) => self::normalize($keyword), $keywords);
        return array_values(array_unique(array_filter($keywords, fn($keyword) => $keyword !== '')));
    }


    /**
     * @return array{keyword: string, volume: int|null}
     */
    public function jsonSerialize(): array
    {
        return ['keyword' => $this->keyword, 'volume' => $this->volume];
    }
}
