<?php

namespace Tests;

use Aimeos\KeywordsBridge\Keyword;
use PHPUnit\Framework\TestCase;


class KeywordTest extends TestCase
{
    public function testNormalize(): void
    {
        $this->assertSame('laravel headless cms', Keyword::normalize(" Laravel \t Headless\nCMS "));
        $this->assertSame('äpfel', Keyword::normalize('ÄPFEL'));
        $this->assertSame('', Keyword::normalize('  '));
    }


    public function testUnique(): void
    {
        $this->assertSame(['laravel cms', 'cms'], Keyword::unique([' Laravel  CMS', '', 'cms', 'laravel cms', ' ']));
    }
}
